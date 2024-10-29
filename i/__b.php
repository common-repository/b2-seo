<?php
class b2_b{
    function b2_b(){
        add_action('thesis_hook_before_headline', array(&$this, '__bo'),10,1);
        remove_action( 'hybrid_before_content', '__hb' );
        add_action( 'hybrid_before_content', array(&$this, '__bo'), 10, 1 );
        add_action('thematic_belowheader', array(&$this, '__bo'),10,1);
        add_action('framework_hook_content_open', array(&$this, '__bo'),10,1);			
    }
    function __bo(){
        $this->__b('<div id="b2_bc">','</div>');
        return;
    }
    function __bon($_i){
        $_o = get_option("b2_seo_b");
        if(isset($_o['_bcbl_']) && $_o['_bcbl_']){
            return '<strong>'.$_i.'</strong>';
        }else{
            return $_i;
        }
    }		
    function __gbt($_i, $_t = 'post_type'){
        $_bct = _gv('_bctt_', $_i);
        return (!empty($_bct))?$_bct : strip_tags(get_the_title($_i));
    }
    function __gtm($_t, $_x){
        $_ot = $_t;
        $_p = array();
        while($_t->parent != 0){
            $_t = get_term($_t->parent, $_x);
            if($_t != $_ot)
                $_p[] = $_t;
        }
        return $_p;
    }
    function __b($_p = '', $_s = '', $_e = true){
        global $wp_query, $post, $paged;
        $_o = get_option("b2_seo_b");
        $_f = get_option('show_on_front');
        $_b = get_option('page_for_posts');
        $_x = (isset($_o['_bsp_']) && $_o['_bsp_'] != '' ) ? $_o['_bsp_'] : '&raquo;';
        $_h = (isset($_o['_hb_']) && $_o['_hb_'] != '' ) ? $_o['_hb_'] : 'Home';
        if($_f == "page"){
            $_l = '<a href="'.get_permalink(get_option('page_on_front')).'">'.$_h.'</a>';
            $bl = $_l;
            if($_b && (!isset($_o['_rbp_']) || !$_o['_rbp_']))
                $_bl = $_l.' '.$_x.' <a href="'.get_permalink($_b).'">'.$this->__gbt($_b).'</a>';
        }else{
            $_l = '<a href="'.get_bloginfo('url').'">'.$_h.'</a>';
            $_bl = $_l;
        }
        if(($_f == "page" && is_front_page()) || ($_f == "posts" && is_home())){
            $_c = $this->__bon($_h);
        }elseif($_f == "page" && is_home()){
            $_c = $_l.' '.$_x.' '.$this->__bon($this->__gbt($_b));
        }else if(is_singular()){
            $_c = $_bl.' '.$_x.' ';
            if(0 == $post->post_parent){
                if(isset($_o['_m-t-p_t-'.$post->post_type.'_'])&&$_o['_m-t-p_t-'.$post->post_type.'_'] != '0'){
                    $_mt = $_o['_m-t-p_t-'.$post->post_type.'_'];
                    $_t = wp_get_object_terms($post->ID, $_mt);
                    if(is_taxonomy_hierarchical($_mt) && $_t[0]->parent != 0){
                        $_ps = $this->__gtm($_t[0], $_mt);
                        foreach($_ps as $_z){
                            $_bct = _gtm($_z, $_mt, 'b2_bct_');
                            if(!$_bct)
                                $_bct = $_z->name;
                            $_c .= '<a href="'.get_term_link($_z, $_mt).'">'.$_bct.'</a> '.$_x.' ';
                        }
                    }
                    if(count($_t) > 0){
                        $_bct = _gtm($_t[0], $_mt, 'b2_bct_');
                        if(!$_bct)
                            $_bct = $_t[0]->name;
                        $_c .= '<a href="'.get_term_link($_t[0], $_mt).'">'.$_bct.'</a> '.$_x.' ';
                    }
                }
                $_c .= $this->__bon( $this->__gbt($post->ID));
            }else{
                if(0 == $post->post_parent){
                    $_c = $_l." ".$_x." ".$this->__bon($this->__gbt());
                }else{
                    if(isset($post->ancestors)){
                        if(is_array($post->ancestors))
                            $_acs = array_values($post->ancestors);
                        else 
                            $_acs = array($post->ancestors);				
                    }else{
                        $_acs = array($post->post_parent);
                    }
                    $_acs = array_reverse($_acs);
                    $_acs[] = $post->ID;
                    $_c = $_l;
                    foreach($_acs as $_ac){
                        $_c .= ' '.$_x.' ';
                        if($_ac != $post->ID)
                            $_c .= '<a href="'.get_permalink($_ac).'">'.$this->__gbt($_ac).'</a>';
                        else
                            $_c .= $this->__bon($this->__gbt($_ac));
                    }
                }
            }
        }else{
            if(!is_404()){
                $_c = $_bl.' '.$_x.' ';
            }else{
                $_c = $_l.' '.$_x.' ';
            }
            if(is_tax() || is_tag() || is_category()){
                $_t = $wp_query->get_queried_object();
                if(is_taxonomy_hierarchical($_t->taxonomy) && $_t->parent != 0){
                    $_ps = $this->__gtm($_t, $_t->taxonomy);
                    foreach($_ps as $_z) {
                        $_bct = _gtm($_z, $_t->taxonomy, 'b2_bct_');
                        if(!$_bct)
                            $_bct = $_z->name;
                        $_c .= '<a href="'.get_term_link($_z, $_t->taxonomy ).'">'.$_bct.'</a> '.$_x.' ';
                    }
                }
                $_bct = _gtm($_t, $_t->taxonomy, 'b2_bct_');
                if(!$_bct)
                    $_bct = $_t->name;
                if($paged)
                    $_c .= $this->__bon('<a href="'.get_term_link($_t, $_t->taxonomy ).'">'.$_bct.'</a>');
                else
                    $_c .= $_bct;
            }else if(is_date()){ 
                if(isset($_o['_apbc_']) )
                    $_q = $_o['_apbc_'];
                else
                    $_q = 'Archives for';
                if(is_day()){
                    global $wp_locale;
                    $_c .= '<a href="'.get_month_link( get_query_var('year'), get_query_var('monthnum') ).'">'.$wp_locale->get_month( get_query_var('monthnum')).' '.get_query_var('year').'</a> '.$_x.' ';
                    $_c .= $this->__bon($_q." ".get_the_date());
                }else if(is_month()){
                    $_c .= $this->__bon($_q." ".single_month_title(' ',false));
                }else if(is_year()) {
                    $_c .= $this->__bon($_q." ".get_query_var('year'));
                }
            }else if(is_author()){
                if(isset($_o['_apbc_']) )
                    $_q = $_o['_apbc_'];
                else
                    $_1 = 'Archives for';
                $_u = $wp_query->get_queried_object();
                $_c .= $this->__bon($_q." ".$_u->display_name);
            }else if(is_search()){
                if ( isset($_o['_spbc_']) && $_o['_spbc_'] != '' )
                    $_q = $_o['_spbc_'];
                else
                    $_q = 'Search for';
                $_c .= $this->__bon($_q.' "'.stripslashes(strip_tags(get_search_query())).'"');
            }elseif(is_404()){
                if(isset($_o['_4pbc_']) && $_o['_4pbc_'] != '')
                    $_4= $_o['_4pbc_'];
                else
                    $_4 = 'Page not found';
                $_c .= $this->__bon($_4);
            }
        }
        if(isset($_o['_pbc_']) && $_o['_pbc_'] != ""){
            $_c = $_o['_pbc_']." ".$_c;
        }
        if($_e){
            echo $_p.$_c.$_s;
        }else{
            return $_p.$_c.$_s;
        }
    }
}
if(!function_exists('b2_breadcrumbs')){
    function b2_breadcrumbs($_p = '', $_s = '', $_e = true) {
        $b2_b = new b2_b();
        $b2_b->__b($_p, $_s, $_e);
    }	
}
