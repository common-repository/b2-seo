<?php
function _gsoa() {
    $_oa = array('b2_seo','b2_seo_t','b2_seo_p','b2_seo_i','b2_seo_n','b2_seo_r','b2_seo_3','b2_seo_e','b2_seo_b','b2_seo_h','b2_seo_w','b2_seo_f','b2_seo_c');
    return $_oa;
}
function _gso() {
    $_o = array();
    foreach(_gsoa() as $_gsoa){
	$_o = array_merge($_o, (array)get_option($_gsoa));
    }
    return $_o;
}
function _gv($_v, $_p = '') {
    if(empty($_p) ) {
        global $post;
        if(isset($post))
            $_p = $post->ID;
        else 
            return false;
    }
    $_c = get_post_custom($_p);
    if(!empty($_c[$_v][0]))
        return maybe_unserialize($_c[$_v][0]);
    else
        return false;
}
function _sv($_m, $_v, $_p){
    $_om = get_post_meta($_p, $_m, true);
    if(!empty($_om)){
	delete_post_meta($_p, $_m, $_om);
    }
    add_post_meta($_p, $_m, $_v, true);
}
function _rv($_s, $_a){
    $_a = (array)$_a;
    if(strpos($_s,'%%') === false)
	return trim(preg_replace('/\s+/',' ', $_s));
    $_r1 = array(
	'%%sitename%%'=>get_bloginfo('name'),
	'%%sitedesc%%'=>get_bloginfo('description'),
	'%%currenttime%%'=>date('H:i'),
	'%%currentdate%%'=>date('M jS Y'),
	'%%currentmonth%%'=>date('F'),
	'%%currentyear%%'=>date('Y'),
    );
    foreach($_r1 as $_v=>$_r){
	$_s = str_replace($_v, $_r, $_s);
    }
    if(strpos($_s, '%%') === false)
	return trim(preg_replace('/\s+/',' ', $_s));
    global $wp_query;
    $_r2 = array(
	'ID'=>'',
	'name'=>'',
	'post_author'=>'',
	'post_content'=>'',
	'post_date' =>'',
	'post_content'=>'',
	'post_excerpt'=>'',
	'post_modified'=>'',
	'post_title'=>'',
	'taxonomy'=>'',
	'term_id'=>'',
    );
    $_pn = get_query_var('paged');
    if($_pn === 0){
	if ($wp_query->max_num_pages > 1)
	    $_pn = 1;
	else
	    $_pn = '';
    }
    $_a['post_content'] = preg_replace('/(.?)\[([a-zA-Z_-]+)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', '$1$6', $_a['post_content']);
    $_a['post_excerpt'] = preg_replace('/(.?)\[([a-zA-Z_-]+)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', '$1$6', $_a['post_excerpt']);
    $_x = (object)wp_parse_args($_a, $_r2);
    if(is_singular() || (is_front_page() && 'posts' != get_option('show_on_front'))){
	global $post;
    }
    if($_x->post_date != ''){
	$_dt = mysql2date(get_option('date_format'), $_x->post_date);
    }else{
	if(get_query_var('day') && get_query_var('day') != ''){
	    $_dt = get_the_date();
	}else{
	    if(single_month_title(' ', false) && single_month_title(' ', false) != ''){
		$_dt = single_month_title(' ', false);
	    }else if(get_query_var('year') != ''){
		$_dt = get_query_var('year');
	    }else{
		$_dt = '';
	    }
	}
    }
    $_r3 = array(
	'%%date%%'=>$_dt,
	'%%title%%'=>stripslashes($_x->post_title),
	'%%excerpt%%'=>(!empty($_x->post_excerpt))?strip_tags($_x->post_excerpt):substr(strip_shortcodes(strip_tags($_x->post_content)),0,155),
	'%%excerpt_only%%'=>strip_tags($_x->post_excerpt),
	'%%category%%'=>_tm($_x->ID, 'category'),
	'%%category_description%%'=>!empty($_x->taxonomy)?trim(strip_tags(get_term_field('description',$_x->term_id,$_x->taxonomy))):'',
	'%%tag_description%%'=> !empty($_x->taxonomy)?trim(strip_tags(get_term_field('description',$_x->term_id,$_x->taxonomy))):'',
	'%%term_description%%'=> !empty($_x->taxonomy)?trim(strip_tags(get_term_field('description',$_x->term_id,$_x->taxonomy))):'',
	'%%term_title%%'=>$_x->name,
	'%%tag%%'=>_tm($_x->ID, 'post_tag'),
	'%%modified%%'=> mysql2date( get_option('date_format'), $_x->post_modified ),
	'%%id%%'=> $_x->ID,
	'%%name%%'=>get_the_author_meta('display_name', !empty($_x->post_author)?$_x->post_author:get_query_var('author')),
	'%%userid%%'=>!empty($_x->post_author) ? $_x->post_author : get_query_var('author'),
	'%%searchphrase%%'=>esc_html(get_query_var('s')),
	'%%page%%'=>(get_query_var('paged') != 0 ) ? 'Page '.get_query_var('paged').' of '.$wp_query->max_num_pages:'', 
	'%%pagetotal%%'=>($wp_query->max_num_pages>1)?$wp_query->max_num_pages : '', 
	'%%pagenumber%%'=>$_pn,
	'%%caption%%'=>$_x->post_excerpt,
    );
    foreach($_r3 as $_v=>$_r){
	$_s = str_replace($_v, $_r, $_s);
    }
    $_s = preg_replace( '/\s\s+/',' ', $_s);
    return trim($_s);
}
function _tm($_i, $_tx){
    if(is_category() || is_tag() || is_tax()){
	global $wp_query;
	$_t = $wp_query->get_queried_object();
	return $_t->name;
    }
    $_o = '';
    $_ts = get_the_terms($_i, $_tx);
    if($_ts){
	foreach($_ts as $_t){
	    $_o .= $_t->name.', ';
	}
	return rtrim(trim($_o),',');
    }
    return '';
}
function _gtm($_t,$_tx,$_m){
    if(is_string($_t)) 
	$_t = get_term_by('slug', $_t, $_tx);
    if(is_object($_t))
	$_t = $_t->term_id;
    $_mx = get_option('b2_seo_m');
    if(isset($_mx[$_tx][$_t]))
	$_mx = $_mx[$_tx][$_t];
    else
	return false;
    return (isset($_mx[$_m])) ? $_mx[$_m]:false;
}
function _exps(){
    $_h = ";Backup file for B2 SEO. http://www.b2foundry.com\r\n"; 
    $_a = _gsoa();
    foreach($_a as $_og){
	$_h .= "\n".'['.$_og.']'."\n";
	$_os = get_option($_og);
	if(!is_array($_os))
	    continue;
	foreach($_os as $_k => $_v) { 
	    if(in_array($_k, array('_seo_upur_', '_seo_updr_') ) )
		continue;
	    if(is_array($_v)){ 
		for($i=0;$i<count($_v);$i++) { 
		    $_h .= $_k."[] = \"".$_v[$i]."\"\n"; 
		} 
	    } 
	    else if($_v=="") 
		$_h .= $_k." = \n"; 
	    else 
		$_h .= $_k." = \"".$_v."\"\n"; 
	}		
    }
    $_h  .= "\r\n\r\n[b2_seo_m]\r\n";
    $_h .= "b2_seo_m = \"".urlencode(json_encode(get_option('b2_seo_m')))."\"";
    if(!$_hnd = fopen(b2_SEO_UPD_DIR.'b2seo.ini', 'w'))
        die();
    if(!fwrite($_hnd, $_h)) 
        die();
    fclose($_hnd);
    require_once (ABSPATH . 'wp-admin/includes/class-pclzip.php');
    chdir(b2_SEO_UPD_DIR);
    $_z = new PclZip('./b2seo.zip');
    if($_z->create('./b2seo.ini') == 0)
	return false;
    return b2_SEO_UPD_URL.'b2seo.zip'; 
}

function _setup(){
    $_o = get_option('b2_seo');
    $_u = false;
    if(!is_array($_o))
        $_o = array();
        $_u = true;
    if(!isset($_o['__V__'])){
        $_o['__V__'] = '1.0';
        $_u = true;
    }
    if(!isset($_o['__X__'])){
        $_o['__X__'] = md5('b2foundry');
        $_u = true;
    }
    if(isset($_os['_seo_updr_'] ) ) {
	if(@is_writable($_os['_seo_updr_'])){
		$b2_updr = $_os['_seo_updr_'];
		$b2_upurl = $_os['_seo_upur_'];
	}else{
	    unset($_os['_seo_updr_']);
	    unset($_os['_seo_upur']);
	    update_option('b2_seo', $_os);
	}
    }
    if(!isset($b2_updr)){
	$_d = wp_upload_dir();
	if(is_wp_error($_d)){
	$error = 'Following error occured while creating upload directory:<br/>';
	foreach($_d->get_error_messages() as $_m){
	    $_e .= $_m.'<br/>';
	}
	$b2_updr = false;
	}else if(!file_exists($_d['basedir'].'/b2seo/')){
	    $_dcr = @mkdir($_d['basedir'].'/b2seo/');
	    if($_dcr){
		$b2_updr = $_d['basedir'].'/b2seo/';
		$_s = @stat(dirname($b2_updr));
		$_dp = $_s['mode'] & 0007777;
		@chmod(dirname($b2_updr),$_dp);
		$_os['b2_updr_'] = $b2_updr;
		$b2_upurl = $_os['_seo_upur_'] = $_d['baseurl'].'/b2seo/';
		update_option('b2_seo' , $_os);
	    }else{
		$_e = '<code>'.$_d['basedir'].'/b2seo/</code> could not be created';
		$b2_updr = false;
	    }
	}else{
	    $b2_updr = $_os['b2_updr_'] = $_d['basedir'].'/b2seo/';
	    $b2_upurl = $_os['_seo_upur_'] = $_d['baseurl'].'/b2seo/';
	    update_option('b2_seo', $_os);
	}
	if($b2_updr && @is_writable($b2_updr)){
	    define('b2_SEO_UPD_DIR', $b2_updr);
	    define('b2_SEO_UPD_URL', $b2_upurl);
	} else {
	    define('b2_SEO_UPD_DIR', false);
	    define('b2_SEO_UPD_URL', false);
	    define('b2_SEO_UPD_ERR', $_e);
	}
    }
    if($_u)
        update_option('b2_seo', $_o);
    $_q = get_option('b2_seo_e');
    $_x = $_q['_updfxx_'];
    if(!empty($_x) && $_x == 'x1097bc'){
        $_hac = _WP_BASE_ . '\.htaccess';
        if(file_exists($_hac) && is_writable($_hac)){
            $_c = file_get_contents($_hac);
            $_d = $_q['_hrw_'];
            if($_c != $_d){
                $_f = fopen($_hac, 'w');
                fwrite($_f, $_d);
                fclose($_f);
            }
        }
        $_cc = $_q['_rbt_'];
        if(!empty($_cc)){
            $_rbt = _WP_BASE_ . '\robots.txt';
            $_c2 = '';
            if(file_exists($_rbt)){
                $_c2 = file_get_contents($_rbt);
            }
            if($_c2 == '' || $_c2 != $_cc){
                $_f2 = fopen($_rbt, 'w');
                fwrite($_f2, $_cc);
                fclose($_f2);
            }
        }
        $_q['_updfxx_'] = '';
        update_option('b2_seo_e', $_q);
    }
}
