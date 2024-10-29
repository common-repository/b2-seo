<?php
class b2_i{
    function b2_i(){
        $_os = _gso();
        if(isset($_os['_li_']) && $_os['_li_']){
            add_action('login_head', array(&$this, '__nip') );
        }
        if(isset($_os['_ad_']) && $_os['_ad_']){
            add_action('admin_head', array(&$this, '__nip') );
        }
        if(isset($_os['_nfm_']) && $_os['_nfm_']) {
            add_filter('loginout',array(&$this,'__nfl'));
            add_filter('register',array(&$this,'__nfl'));
        }
    }
    function __nip(){
        echo "<!-- B2 SEO -->\n";
        echo "\t".'<meta name="robots" content="noindex" />'."\n";
        echo "<!-- End of B2 SEO -->\n";
    }
    function __nfl($_c){
        return str_replace('<a ','<a rel="nofollow" ',$_c);
    }
}
$b2_i = new b2_i();