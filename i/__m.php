<?php

class b2_m{
    var $_l = 155;
   
    function b2_m() {
        add_action('admin_print_scripts', array(&$this,'_ajs'));
        add_action('admin_print_styles', array(&$this,'_acs'));	
        
                
        add_action('admin_menu', array(&$this,'_cmb') );
        add_action('save_post', array(&$this,'_spt') );
    }
    
    function _ajs() {
        global $pagenow;
        if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php'))){
            wp_enqueue_script('b2_seo_mb', B2_SEO_URL.'js/b2_seo_mb.js', array('jquery'));
        }
    }
    
    function _acs() {
        global $pagenow;
        if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php'))) {
            wp_enqueue_style('b2_seo_mb', B2_SEO_URL.'css/b2_seo_mb.css');
        }
    }
    
    function _gmb($_t = 'post'){
        $_os = _gso();
        $_m = array();
        $_m['_ptt_'] = array(
            "_nm_" => "_ttl_",
            "_st_" => "",
            "_tp_" => "x",
            "_tt_" => "SEO Title",
            "_de_" => "Title to be displayed in search engines. Leave blank to use the default title."
        );
        $_m['_pmd_'] = array(
            "_nm_" => "_mds_",
            "_st_" => "",
            "_cl_" => "md",
            "_tp_" => "a",
            "_tt_" => "Meta Description",
            "_rw_" => 2,
            "_re_" => false
        );
		$_m['_mkw_'] = array(
			"_nm_" => "_mkwd_",
			"_st_" => "",
			"_cl_" => "mk",
			"_tp_" => "x",
			"_tt_" => "Meta Keywords",
			"_de_" => "If you type something above it will override your <a target='_blank' href='".admin_url('admin.php?page=t#'.$_t)."'>meta keywords template</a>."
		);
        $_m['_mri_'] = array(
            "_nm_" => "_mrnoi_",
            "_st_" => "index",
            "_tt_" => "Robots Index",
            "_tp_" => "r",
            "_opt_" => array(
                    "0" => "Index",
                    "1" => "Noindex",
            ),
        );
        $_m['_mrf_'] = array(
            "_nm_" => "_mrnof_",
            "_st_" => "follow",
            "_tt_" => "Robots Follow",
            "_tp_" => "r",
            "_opt_" => array(
                    "0" => __("Follow"),
                    "1" => __("Nofollow"),
            ),
        );
        $_m['_mra_'] = array(
            "_nm_" => "_mradv_",
            "_st_" => "none",
            "_tp_" => "m",
            "_tt_" => "Robots Advanced",
            "_de_" => "Advanced <code>meta</code> robots settings.",
            "_opt_" => array(
                    "noodp" => "noodp",
                    "noydir" => "noydir",
                    "noarchive" => "noarchive",
                    "nosnippet" => "nosnippet",
            ),
        );
        if(isset($_os['_tbc_']) && $_os['_tbc_']) {
            $_m['_bct_'] = array(
                "_nm_" => "_bctt_",
                "_st_" => "",
                "_tp_" => "x",
                "_tt_" => "Breadcrumbs Title",
                "_de_" => "Title to use for this page in breadcrumb",
            );
        }
        $_m['_cnl_'] = array(
            "_nm_" => "_conl_",
            "_st_" => "",
            "_tp_" => "x",
            "_tt_" => "Canonical URL",
            "_de_" => "Leave empty if you want to use the same as the permalink."
        );
        $_m['_rdr_'] = array(
            "_nm_" => "_redr_",
            "_st_" => "",
            "_tp_" => "x",
            "_tt_" => "Permanent(301) Redirect"
        );
        
        return $_m;
    }
    function _mbx() {
        global $post;
        echo '<table class="b2t">';
        foreach($this->_gmb($post->post_type) as $_mb) {
            $this->_emb($_mb);
        }
        echo '</table>';
    }
    
    function _emb($_mb) {
        global $post;
        if (!isset($_mb['_nm_'])) {
            $_mb['_nm_'] = '';
        } else {
            $_mbv = _gv($_mb['_nm_']);
        }
        $_cl = '';
        if(!empty($_mb['_cl_']))
            $_cl = ' '.$_mb['_cl_'];
        if((!isset($_mbv) || empty($_mbv) ) && isset($_mb['_st_']) )  
            $_mbv = $_mb['_st_'];  
        echo '<tr><th><label for="b2_seo'.$_mb['_nm_'].'">'.$_mb['_tt_'].':</label></th><td>';
        switch($_mb['_tp_']){ 
            case "x":
                echo '<input type="text" id="b2_seo'.$_mb['_nm_'].'" name="'.$_mb['_nm_'].'" value="'.$_mbv.'" class="ti '.$_cl.'"/><br />';  
                break;
            case "a":
                $_r = 5;
                if(isset($_mb['_rw_']))
                    $_r = $_mb['_rw_'];
                echo '<textarea class="ta '.$_cl.'" rows="'.$_r.'" id="b2_seo'.$_mb['_nm_'].'" name="'.$_mb['_nm_'].'">'.$_mbv.'</textarea>';
            break;
            case "s":
                echo '<select name="'.$_mb['_nm_'].'" id="b2_seo'.$_mb['_nm_'].'" class="st '.$_cl.'">';
                foreach($_mb['_opt_'] as $_v=>$_o){
                    $_s = '';
                    if($_mbv == $_v)
                        $_s = 'selected="selected"';
                    echo '<option '.$_s.' value="'.$_v.'">'.$_o.'</option>';
                }
                echo '</select>';
            break;
            case "m":
                $_sa = explode(',',$_mbv);
                $_mb['_opt_'] = array('none'=>'None') + $_mb['_opt_'];
                echo '<select multiple="multiple" size="'.count($_mb['_opt_']).'" style="height: '.(count($_mb['_opt_'])*16).'px;" name="'.$_mb['_nm_'].'[]" id="b2_seo'.$_mb['_nm_'].'" class="st '.$_cl.'">';
                foreach($_mb['_opt_'] as $_v=>$_o){
                    $_s = '';
                    if(in_array($_v,$_sa))
                        $_s = 'selected="selected"';
                    echo '<option '.$_s.' value="'.$_v.'">'.$_o.'</option>';
                }
                echo '</select>';
            break;
            case "r":
                if($_mbv == '')
                    $_mbv = $_mb['_st_'];
                foreach($_mb['_opt_'] as $_v=>$_o){
                    $_s = '';
                    if($_mbv == $_v)
                        $_s = 'checked="checked"';
                    echo '<input type="radio" '.$_s.' id="b2_seo'.$_mb['_nm_'].$_v.'" name="'.$_mb['_nm_'].'" value="'.$_v.'"/> <label for="b2_seo'.$_mb['_nm_'].'_'.$_v.'">'.$_o.'</label> ';
                }
            break;
        }
        if(isset($_mb['_de_']) )
            echo '<p>'.$_mb['_de_'].'</p>';
        echo '</td></tr>';	
    }
    function _cmb(){
        $_os = _gso();
        if(function_exists('add_meta_box') ) {  
            foreach(get_post_types() as $_t){
                if(in_array( $_t, array('revision','nav_menu_item','post_format','attachment')))
                    continue;
                if(isset($_os['_'.$_t.'-h-eb_']) && $_os['_'.$_t.'-h-eb_'])
                    continue;
                add_meta_box('b2_seo_mb', 'B2 SEO', array(&$this, '_mbx'), $_t, 'normal', 'high' );  
            }
        }  
    }
    
    function _spt($_p){  
        if ($_p == null || empty($_POST))
            return;
        if(wp_is_post_revision($_p))
           $_p = wp_is_post_revision($_p);
        global $post;  
        if(empty($post))
        $post = get_post($_p);
        foreach($this->_gmb($post->post_type) as $_mb){  
            if(!isset($_mb['_nm_']))
                continue;
        if('page' == $_POST['post_type']){  
            if(!current_user_can('edit_page', $post_id))  
                return $_p;  
        }else{  
            if(!current_user_can('edit_post', $_p))  
                return $post_id;  
        }  
        if(isset($_POST[$_mb['_nm_']]))
            $_d = $_POST[$_mb['_nm_']];  
        else
            continue;
        if($_mb['_tp_'] == 'm'){
            if(is_array($_POST[$_mb['_nm_']]))
                $_d = implode( ",", $_POST[$_mb['_nm_']]);
            else
                $_d = $_POST[$_mb['_nm_']];
        }
        $_o = $_mb['_nm_'];
        $_ov = get_post_meta($_p, $_o);
        if($_ov == "")  
            add_post_meta($_p, $_o, $_d, true);  
        elseif($_d != $_ov)
            update_post_meta($_p, $_o, $_d);  
        elseif($_d == "")  
            delete_post_meta($_p, $_o, $_ov);  
        }
    }
}
$b2_mb = new b2_m();
