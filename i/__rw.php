<?php
class b2_rw{
    function b2_rw(){
        $_os = _gso();
	add_filter('query_vars', array(&$this, '_qv'));
        if(isset($_os['_rcb_']) && $_os['_rcb_']){
            add_filter( 'category_link', array(&$this, '_ncb'), 1000, 2 );
            add_filter( 'request', array(&$this, '_ncbr') );
            add_filter( 'category_rewrite_rules', array(&$this, '_cwr') );
            
            add_action('created_category', array(&$this, '_fr') );
            add_action('edited_category', array(&$this, '_fr') );
            add_action('delete_category', array(&$this, '_fr') );
        }
    }
    function _qv($_qv){
        $_oss = _gso();
        if(isset($_oss['_rcb_']) && $_oss['_rcb_']){
            $_qv[] = '_rcbr_';
        }
        return $_qv;
    }
    function _ncb($_cl, $_id){
        $_c = &get_category($_id);
        if(is_wp_error($_c))
            return $_c;
        $_cs = $_c->slug;
        if($_c->parent == $_id)
            $_c->parent = 0;
        elseif($_c->parent != 0)
            $_cs = get_category_parents($_c->parent, false, '/', true ) . $_cs;
        $_cl = trailingslashit(get_option('home')) . trailingslashit($_cs);
        return $_cl;
    }
    function _ncbr($_qv){
        if( isset($_qv['_rcbr_'])){
            $_cl = trailingslashit(get_option('home')) . trailingslashit($_qv['_rcbr_']);
            wp_redirect($_cl, 301);
            exit;
        }
        return $_qv;
    }
    function _cwr($_r){
        global $wp_rewrite;
        $_cr = array();
        $_cs = get_categories(array('hide_empty'=>false));
        foreach($_cs as $_c) {
            $_cn = $_c->slug;
            if($_c->parent == $_c->cat_ID )
                $_c->parent = 0;
            elseif($_c->parent != 0 )
                $_cn = get_category_parents($_c->parent, false, '/', true ) . $_cn;
            $_cr['('.$_cn.')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
            $_cr['('.$_cn.')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $_cr['('.$_cn.')/?$'] = 'index.php?category_name=$matches[1]';
        }
        $_ob = $wp_rewrite->get_category_permastruct();
        $_ob = str_replace('%category%', '(.+)', $_ob);
        $_ob = trim($_ob, '/');
        $_cr[$_ob.'$'] = 'index.php?_rcbr_=$matches[1]';
        return $_cr;
    }
    function _fr(){
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }
}
$b2_rw = new b2_rw();