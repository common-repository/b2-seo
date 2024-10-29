<?php
class b2_r{
    function b2_r(){
        $_os = _gso();
        add_action('wp_head', array(&$this, '__h'));
        remove_action('wp_head', 'rel_canonical');
        add_filter( 'wp_title', array(&$this, '__t'), 10, 3);
        add_action('wp',array(&$this,'__pr'),99,1);
        if(isset($_os['_tsh_']) && $_os['_tsh_']){
            add_filter('_uts', array(&$this, '__ats') , 10, 2);
        }
        if(isset($_os['_alf_']) && $_os['_alf_']) {
            add_action('rss_head', array(&$this, '__nif') );
            add_action('rss2_head', array(&$this, '__nif') );
            add_action('commentsrss2_head', array(&$this, '__nif') );
        }else if (isset($_os['_cmf_']) && $_os['_cmf_']) {
            add_action('commentsrss2_head', array(&$this, '__nif') );
        }
        if(isset($_os['_hrsd_']) && $_os['_hrsd_'])
            remove_action('wp_head', 'rsd_link');
        if(isset($_os['_hwlm_']) && $_os['_hwlm_'])
            remove_action('wp_head', 'wlwmanifest_link');
        if(isset($_os['_hwpg_']) && $_os['_hwpg_'])
            add_filter('the_generator', array(&$this, '__fg') ,10,1);
        if(isset($_os['_hir_']) && $_os['_hir_'])
            remove_action('wp_head', 'index_rel_link');
        if(isset($_os['_hsr_']) && $_os['_hsr_'])
            remove_action('wp_head', 'start_post_rel_link');
        if(isset($_os['_hpnp_']) && $_os['_hpnp_'])
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
        if(isset($_os['_hsl_']) && $_os['_hsl_'])
            remove_action('wp_head', 'wp_shortlink_wp_head');
        if(isset($_os['_hfl_']) && $_os['_hfl_']){
            remove_action('wp_head', 'feed_links', 2);
            remove_action('wp_head', 'feed_links_extra', 3);
        }
        if((isset($_os['_dsd_']) && $_os['_dsd_']) || (isset($_os['_dsa_']) && $_os['_dsa_']))
            add_action('wp', array(&$this, '__ar') );

        if(isset($_os['_nfcl_']) && $_os['_nfcl_'])
            add_filter('comments_popup_link_attributes',array(&$this,'__nfc'));
        if (isset($_os['_cln_']) && $_os['_cln_'])
            add_action('template_redirect',array(&$this,'__cl'),1);	
        
        add_filter('the_content_feed', array(&$this, '__ers') );
        add_filter('the_excerpt_rss', array(&$this, '__ere') );	
        
        if (isset($_os['_rtf_']) && $_os['_rtf_']) {
            add_action('get_header', array(&$this, '__frt') );
            add_action('wp_footer', array(&$this, '__fc') );			
        }
        add_filter('the_content', array(&$this, '__tc'));
        add_action('wp_footer', array(&$this, '__cdf') );
    }
    function __h(){
        $_os = _gso();
        echo "<!-- B2 SEO -->\n";
        $this->__mds();
        $this->__mkw();
        $this->__rbt();
        $this->__cnl();
        if(is_front_page()){
            if(!empty($_os['_gv_'])){
                $_m = $_os['_gv_'];
                if(strpos($_m, 'content') ) {
                    preg_match('/content="([^"]+)"/', $_m, $_q);
                    $_m = $_q[1];
                }
                echo "\t<meta name='google-site-verification' content='$_m' />\n";
            }
            if(!empty($_os['_yv_'])){
                $_m = $_os['_yv_'];
                if(strpos($_m, 'content') ) {
                    preg_match('/content="([^"]+)"/', $_m, $_q);
                    $_m = $_q[1];
                }
                echo "\t<meta name='y_key' content='$_m' />\n";
            }
            if(!empty($_os['_bv_'])){
                $_m = $_os['_bv_'];
                if(strpos($_m, 'content') ) {
                    preg_match('/content="([^"]+)"/', $_m, $_q);
                    $_m = $_q[1];
                }
                echo "\t<meta name='msvalidate.01' content='$_m' />\n";
            }
        }
        $this->__cde();
        echo "\n<!-- End of B2 SEO -->\n";
    }
	function get_meta_desc(){
        if(get_query_var('paged') && get_query_var('paged') > 1)
            return;
        global $post, $wp_query;
        $_os = _gso();
        $_mds = '';
        if(is_singular()){ 
            $_mds = _gv('_mds_');
            if($_mds == '' || !$_mds){
                if(isset($_os['_'.$post->post_type.'-m-d_']) && $_os['_'.$post->post_type.'-m-d_'] != '')
                $_mds = _rv($_os['_'.$post->post_type.'-m-d_'],(array)$post);
            }
        }else{
            if(is_home() && 'posts' == get_option('show_on_front') && isset($_os['_hmd_'])){
                $_mds = _rv($_os['_hmd_'],array());
            }else if(is_home() && 'posts' != get_option('show_on_front')){
                $post = get_post(get_option('page_for_posts'));
                $_mds = _gv('_mds_');
                if(($_mds == '' || !$_mds) && isset($_os['_'.$post->post_type.'-m-d_']))
                    $_mds = _rv($_os['_'.$post->post_type.'-m-d_'],(array)$post);
                }else if(is_category() || is_tag() || is_tax()){
                    $_tm = $wp_query->get_queried_object();
                    $_mds = _gtm($_tm, $_tm->taxonomy, 'b2_de_');
                    if(!$_mds && isset($_os['_'.$_tm->taxonomy.'-m-d_']))
                        $_mds = _rv($_os['_'.$_tm->taxonomy.'-m-d_'], (array)$_tm);
                }else if(is_author()){
                    $_aid = get_query_var('author');
                    $_mds = get_the_author_meta('_mds_', $_mds);
                    if(!$_mds && isset($_os['_author-m-d_']))
                    $_mds = _rv($_os['_author-m-d_'], (array)$wp_query->get_queried_object() );
                } 
        }
        $_mds = trim($_mds);
        if(!empty($_mds))
            echo esc_attr(strip_tags(stripslashes($_mds)));
	}
    function __mds(){
        if(get_query_var('paged') && get_query_var('paged') > 1)
            return;
        global $post, $wp_query;
        $_os = _gso();
        $_mds = '';
        if(is_singular()){ 
            $_mds = _gv('_mds_');
            if($_mds == '' || !$_mds){
                if(isset($_os['_'.$post->post_type.'-m-d_']) && $_os['_'.$post->post_type.'-m-d_'] != '')
                $_mds = _rv($_os['_'.$post->post_type.'-m-d_'],(array)$post);
            }
        }else{
            if(is_home() && 'posts' == get_option('show_on_front') && isset($_os['_hmd_'])){
                $_mds = _rv($_os['_hmd_'],array());
            }else if(is_home() && 'posts' != get_option('show_on_front')){
                $post = get_post(get_option('page_for_posts'));
                $_mds = _gv('_mds_');
                if(($_mds == '' || !$_mds) && isset($_os['_'.$post->post_type.'-m-d_']))
                    $_mds = _rv($_os['_'.$post->post_type.'-m-d_'],(array)$post);
                }else if(is_category() || is_tag() || is_tax()){
                    $_tm = $wp_query->get_queried_object();
                    $_mds = _gtm($_tm, $_tm->taxonomy, 'b2_de_');
                    if(!$_mds && isset($_os['_'.$_tm->taxonomy.'-m-d_']))
                        $_mds = _rv($_os['_'.$_tm->taxonomy.'-m-d_'], (array)$_tm);
                }else if(is_author()){
                    $_aid = get_query_var('author');
                    $_mds = get_the_author_meta('_mds_', $_mds);
                    if(!$_mds && isset($_os['_author-m-d_']))
                    $_mds = _rv($_os['_author-m-d_'], (array)$wp_query->get_queried_object() );
                } 
        }
        $_mds = trim($_mds);
        if(!empty($_mds))
            echo "\t<meta name='description' content='".esc_attr(strip_tags(stripslashes($_mds)))."'/>\n";
        else if(current_user_can('manage_options') && is_singular())
            echo "\t".'<!-- No meta description has been defined. Please define that using the 2n SEO plugin -->'."\n";
		
    }
    function __mkw(){
        global $wp_query;
        $_os = _gso();
        //if(!isset($_os['_umkw_']) || !$_os['_umkw_'])
            //return;
		//Metakeywords are allowed by default!!
        if(is_singular()){ 
            global $post;
            $_mk = _gv('_mkwd_');
            if(!$_mk || empty($_mk)){
                $_mk = _rv($_os['_'.$post->post_type.'-m-k_'],(array) $post);
            }
        }else{
            if(is_home() && 'posts' == get_option('show_on_front') && isset($_os['_hmkw_'])){
                $_mk = _rv($_os['_hmkw_'], array());
            }else if(is_home() && 'posts' != get_option('show_on_front')){
                $post = get_post(get_option('page_for_posts'));
                $_mk = _gv('_mkwd_');
                if(($_mk == '' || !$_mk) && isset($_os['_'.$post->post_type.'-m-k_']))
                    $_mk = _rv($_os['_'.$post->post_type.'-m-k_'], (array)$post);
            }else if(is_category() || is_tag() || is_tax()){
                $_t = $wp_query->get_queried_object();
                $_mk = _gtm($_t, $_t->taxonomy, 'b2_mk_');
                if(!$_mk && isset($_mk['_'.$_t->taxonomy.'-m-k_']))
                    $_mk = _rv($_os['_'.$_t->taxonomy.'-m-k_'], (array) $_t);
            }else if(is_author()){
                $_a = get_query_var('author');
                $_mk = get_the_author_meta('_mkw_', $_a);
                if(!$_mk && isset($_os['_author-m-k_']))
                    $_mk = _rv($_os['_author-m-k_'], (array)$wp_query->get_queried_object());
            } 
        }
        $_mk = trim($_mk);
        if(!empty($_mk)) 
            echo "\t<meta name='keywords' content='".esc_attr(strip_tags(stripslashes($_mk)))."'/>\n";
    }
    function __rbt(){
        $_os = _gso();
        global $wp_query;
        $_r = array();
        $_r['i'] = 'index';
        $_r['f'] = 'follow';
        $_r['o'] = array();
        if(is_singular()){
            if(_gv('_mrnoi_'))
                $_r['i'] = 'noindex';
            if(_gv('_mrnof_') )
                $_r['f'] = 'nofollow';
            if(_gv('_mradv_') && _gv('_mradv_') != 'none'){ 
                foreach(explode(',', _gv('_mradv_') ) as $_b){
                    $_r['o'][] = $_b;
                }
            }
        }else{
            if( 
                (is_author() && isset($_os['_nia_']) && $_os['_nia_']) ||
                (is_category() && isset($_os['_nie_']) && $_os['_nie_']) || 
                (is_date() && isset($_os['_nid_']) && $_os['_nid_']) || 
                (is_tag() && isset($_os['_nit_']) && $_os['_nit_']) || 
                (is_search() && isset($_os['_sr_']) && $_os['_sr_']) || 
                (is_home() && isset($_os['_sp_']) && $_os['_sp_'] && get_query_var('paged') > 1))
            {
                $_r['i'] = 'noindex';
                $_r['f'] = 'follow';
            }
            if(is_tax() || is_tag() || is_category()){
                $_t = $wp_query->get_queried_object();
                if(_gtm($_t, $_t->taxonomy, 'b2_noi_'))
                    $_r['i'] = 'noindex';
                if(_gtm($_t, $_t->taxonomy, 'b2_nof_'))
                    $_r['f'] = 'nofollow';
             }
        }
        foreach(array('_ndp_','_nyd_','_nar_','_nsp_') as $_b){
            if(isset($_os[$_b]) && $_os[$_b]){
                switch($_b){
                    case "_ndp_":
                        $_r['o'][] = "nodp";
                        break;
                    case "_nyd_":
                        $_r['o'][] = "noydir";
                        break;
                    case "_nar_":
                        $_r['o'][] = "noarchive";
                        break;
                    case "_nsp_":
                        $_r['o'][] = "nosnippet";
                        break;
                }
            }
        }
        $_s = $_r['i'].','.$_r['f'];
        $_r['o'] = array_unique($_r['o']);
        foreach($_r['o'] as $_b){
            $_s .= ','.$_b;
        }
        $_s = preg_replace('/^index,follow,?/', '', $_s);
        if($_s != '') {
            echo "\t<meta name='robots' content='".$_s."'/>\n";
        }
    }
    function __cnl(){
        global $wp_query, $paged;
        if(is_singular()){
            global $post;
            if(_gv('_conl_') && _gv('_conl_') != ''){ 
                $_c = _gv('_conl_');
            }else{
                $_c = get_permalink($post->ID);
                $_p = get_query_var('page');
                if($_p && $_p != 1){
                    if(substr_count($wp_query->queried_object->post_content, '<!--nextpage-->') >= ($_p-1))
                        $_c = trailingslashit($_u . get_query_var('page'));
                }
            }
        }else{
            if(is_front_page()){
                $_c = get_bloginfo('url').'/';
            }else if(is_home() && get_option('show_on_front') == "page"){
                $_c = get_permalink(get_option( 'page_for_posts'));
            }else if(is_tax() || is_tag() || is_category()){
                $_t = $wp_query->get_queried_object();
                $_c = _gtm($_t, $_t->taxonomy, 'b2_cl_');
                if(!$_c)
                    $_c = get_term_link($_t, $_t->taxonomy);
            }else if(is_archive()){
                if(is_date()){
                    if(is_day()){
                        $_c = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
                    }else if(is_month()){
                        $_c = get_month_link(get_query_var('year'), get_query_var('monthnum'));
                    }else if( is_year()){
                        $_c = get_year_link(get_query_var('year'));
                    }						
                }
            }
            if(isset($paged) && $paged && !empty($_c))
                $_c = trailingslashit($_c . 'page/');
        }
        if(!empty($_c)){
            echo "\t".'<link rel="canonical" href="'.$_c.'" />'."\n";
        }
    }
    function __ats($_u, $_t) {
        if('single' === $_t){
            return $_u;
        }else{
            return trailingslashit($_u);
        }
    }
    function __t($_t, $_s = '|', $_sl = '', $_p = ''){
        global $post, $wp_query;
        if(empty($post) && is_singular()){
            $post = $wp_query->get_queried_object();
        }
        $_os = _gso();
        if(is_home() && 'posts' == get_option('show_on_front')){
            if(isset($_os['_ht_']) && $_os['_ht_'] != '')
                $_t = _rv($_os['_ht_'], array());
            else
                $_t = get_bloginfo('name').' '.$_s.' '.get_bloginfo('description');
        }else if(is_home() && 'posts' != get_option('show_on_front')){
            $post = get_post(get_option('page_for_posts'));
            $_ft = _gv('_ttl_');
            if($fixed_title){ 
                $_t = $_ft; 
            }else{
                if(isset($_os['_'.$post->post_type.'-t_']) && !empty($_os['_'.$post->post_type.'-t_']) )
                    $_t = _rv($_os['_'.$post->post_type.'-t_'], (array) $post);
                else
                    $_t = get_bloginfo('name').' '.$_s.' '.get_bloginfo('description');
            }
        }else if(is_singular()){
            $_ft = _gv('_ttl_');
            if($_ft){ 
                $_t = $_ft; 
            }else{
                if(isset($_os['_'.$post->post_type.'-t_']) && !empty($_os['_'.$post->post_type.'-t_']))
                    $_t = _rv($_os['_'.$post->post_type.'-t_'], (array) $post);
                else
                    $_t = $post->post_title.' '.$_s.' '.get_bloginfo('name'); 
            }
        }else if(is_category() || is_tag() || is_tax()){
            $_m = $wp_query->get_queried_object();
            $_t = trim(_gtm($_m, $_m->taxonomy, 'b2_tt_'));
            if(!$_t || empty($_t)){
                if(isset($_os['_'.$_m->taxonomy.'-t_']) && !empty($_os['_'.$_m->taxonomy.'-t_'])){
                    $_t = _rv($_os['_'.$_m->taxonomy.'-t_'], (array) $_m);
                }else{
                    if(is_category())
                        $_t = single_cat_title('', false);
                    else if(is_tag())
                        $_t = single_tag_title('', false);
                    else if (is_tax()){
                        if(function_exists('single_term_title')){
                            $_t = single_term_title('', false);
                        }else{
                            $_m = $wp_query->get_queried_object();
                            $_t = $_m->name;
                        }
                    }
                    $_t .= ' '.$_s.' '.get_bloginfo('name'); 
                }
            }
        }elseif(is_search()){
            if(isset($_os['_search-t_']) && !empty($_os['_search-t_']))
                $_t = _rv($_os['_search-t_'], (array) $wp_query->get_queried_object());	
            else
                $_t = 'Search Results for "'.get_search_query().'" '.$_s.' '.get_bloginfo('name');
        }else if(is_author()){
                $_a = get_query_var('author');
                $_t = get_the_author_meta('_ttl_', $author_id);
                if(empty($_t)){
                    if(isset($_os['_author-t_']) && !empty($_os['_author-t_']))
                        $_t = _rv($_os['_author-t_'], array());
                    else
                        $_t = get_the_author_meta('display_name', $_a).' '.$_s.' '.get_bloginfo('name'); 
                }
        }else if(is_archive()){
                if(isset($_os['_archive-t_']) && !empty($_os['_archive-t_']))
                    $_t = _rv($_os['_archive-t_'], array('post_title' => $_t));
                else{
                    if(is_month())
                        $_t = single_month_title(' ', false).' Archives '.$_s.' '.get_bloginfo('name'); 
                    else if(is_year())
                        $_t = get_query_var('year').' Archives '.$_s.' '.get_bloginfo('name'); 
                }
        }else if(is_404()){
                if(isset($_os['_404-t_']) && !empty($_os['_404-t_']))
                    $_t = _rv($_os['_404-t_'], array('post_title' => $title));
                else
                    $_t = 'Page not found '.$_s.' '.get_bloginfo('name');
        } 
        return esc_html(stripslashes($_t));
    }
    function __pr($_i){
        if(!is_home() && is_singular()){
            global $post;
            if(!isset($post))
                return;
            $_r = _gv('_redr_', $post->ID);
            if(!empty($_r)){
                wp_redirect($_r, 301);
                exit;
            }
        }
    }
    function __nif(){
        echo '<xhtml:meta xmlns:xhtml="http://www.w3.org/1999/xhtml" name="robots" content="noindex" />'."\n";
    }
    function __fg($_g){
	return '';//preg_replace('/\s?'.get_bloginfo('version').'/','',$_g);
    }
    function __cde(){
        $_os = _gso();
        if($_os['_htc_'] && !empty($_os['_htc_'])){
            echo "\t" . $_os['_htc_'];
        }
    }
    function __ar(){
        global $wp_query;
        $_os  = _gso();
        if(($_os['_dsd_'] && $wp_query->is_date) || ($_os['_dsa_'] && $wp_query->is_author)){
            wp_redirect(get_bloginfo('url'),301);
            exit;
        }
    }
    function __aar(){
        global $post;
        if(is_attachment()){
            wp_redirect(get_permalink($post->post_parent), 301);
            exit;
        }
    }
    function __nfc(){
	return ' rel="nofollow"';
    }
    function __cl($_h){
        if(is_robots())
            return;
        global $wp_query;
        $_os = _gso();
        $_cu = 'http';
        if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
            $_cu .= "s";
        }
        $_cu .= "://";
        if($_SERVER["SERVER_PORT"] != "80")
            $_cu .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
            $_cu .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        $_u = '';
        if(is_singular()){
            $_u = get_permalink($wp_query->post->ID);
            $_p = get_query_var('page');
            if($_p && $_p != 1){
                if(substr_count($wp_query->queried_object->post_content, '<!--nextpage-->') >= ($_p-1))
                    $_u = trailingslashit($_u . get_query_var('page'));
            }
            $_r = preg_match('/(\?replytocom=[^&]+)/', $_SERVER["REQUEST_URI"], $_m);
            if($_r)
                $_u .= str_replace('?replytocom=','#comment-',$_m[0]);
        }else if(is_front_page()){
            if('posts' == get_option('show_on_front') && is_home()){
                $_u = get_bloginfo('url').'/';
            }elseif('page' == get_option('show_on_front')){
                $_u = get_permalink(get_option('page_on_front'));
            }
        }else if(is_category() || is_tag() || is_tax()){
                $_t = $wp_query->get_queried_object();
                $_u = get_term_link($_t, $_t->taxonomy);
        }else if(is_search()){
                $_s = preg_replace( '/(%20|\+)/', ' ', get_search_query() );
                $_u = get_bloginfo('url').'/?s=' . rawurlencode($_s);
        }
        if(!empty($_u) && $wp_query->query_vars['paged'] != 0 && $wp_query->post_count != 0){
            if(is_search()){
                $_u = get_bloginfo('url').'/page/' . $wp_query->query_vars['paged'] . '/?s=' . rawurlencode($_s);
            }else{
                $_u = trailingslashit($_u . 'page/' . $wp_query->query_vars['paged']);
            }
        }
        foreach(array('wp-subscription-manager') as $_g){
            if(isset($_GET[$_g])){
                $_u = '';
            }		
        }
        if(!empty($_u) && $_cu != $_u){	
            wp_redirect($_u, 301);
            exit;
        }
    }
    function __ers($_c){
        if(is_feed()){
            $_os = _gso();
            if(isset($_os['_rbf_']) && !empty($_os['_rbf_']) ) {
                $_c = "<p>".$this->__rrv($_os['_rbf_'])."</p>".$_c;
            } 
            if ( isset($_os['_raf_']) && !empty($_os['_raf_']) ) {
                $_c .= "<p>".$this->__rrv($_os['_raf_']). "</p>";
            } 
        }
        return $_c;
    }
    function __ere($_c){
        if(is_feed()) {
            $_os = _gso();
            if(isset($_os['_rbf_']) && !empty($_os['_rbf_'])){
                $_c = "<p>".$this->__rrv($_os['_rbf_']) . "</p><p>".$_c."</p>";
            } 
            if(isset($_os['_raf_']) && !empty($_os['_raf_'])){
                $_c = "<p>".$_c."</p><p>".$this->__rrv($_os['_raf_'])."</p>";
            } 
        }
        return $_c;
    }
    function __rrv($_x){
        $_p = '<a href="'.get_permalink().'">'.get_the_title()."</a>";
        $_b = '<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a>';
        $_c = '<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').' - '.get_bloginfo('description').'</a>';
        $_x = stripslashes($_x);
        $_x = str_replace("%%POSTLINK%%", $_p, $_x);
        $_x = str_replace("%%BLOGLINK%%", $_b, $_x);		
        $_x = str_replace("%%BLOGDESCLINK%%", $_c, $_x);					
        return $_x ;
    }
    function __frt(){
        global $wpseo_ob;
        $wpseo_ob = true;
        ob_start();
    }
    function __fc(){
        global $wp_query, $post, $wpseo_ob;
        if ( !$wpseo_ob )
            return;
        $_c = ob_get_contents();
        $_t = $this->__t('');
        $_c = preg_replace('/<title>(.*)<\/title>/','<title>'.$_t.'</title>', $_c);
        ob_end_clean();
        echo $_c;
    }
    function __tc($_c){
        $_os = _gso();
        if($_os['_bitc_']&& !empty($_os['_bitc_'])){
            $_c = $_os['_bitc_'] . $_c;
        }
        if($_os['_aitc_'] && !empty($_os['_aitc_'])){
            $_c = $_c . $_os['_aitc_'];
        }
        if(is_singular){
            if($_os['_rat_'] && !empty($_os['_rat_'])){
                $_script = "<script type='text/javascript'>__ = jQuery.noConflict();
                __('img').each(function(){
                var parent = __(this).parent();
                var href = parent.attr('href');
                if(href && href != 'undefined' && !parent.hasClass('logo-image')){
                    //parent.replaceWith(__(this));
                    href = '";
                global $wp_query;
                $_script .= get_permalink($wp_query->post->ID);;
                $_script .= "'
                    parent.attr({'href':href});
                }
                });
                </script>";
                $_c .= $_script;
            }
        }
        return $_c;
    }
    function __cdf(){
        $_os = _gso();
        if($_os['_ftc_'] && !empty($_os['_ftc_'])){
            echo $_os['_ftc_'];
        }
    }
}
$b2_r = new b2_r();