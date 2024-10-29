<?php
if(!class_exists('b2_a')){
    class b2_a extends b2_c{
        var $_mt = 'B2 SEO';
        var $_pt = 'B2 SEO Plugin';
        var $_ic = 'icon.png';
        var $_hk = 'seo';
        var $_fl = 'SEO/seo.php';
        var $_hm = 'http://www.b2foundry.com';
        var $_cp = 'b2_seo';
        var $_df = 'b2_seo';
        function b2_a(){
            add_action('init', array(&$this, 'b2_x'));
        }
        function b2_x(){
            add_action('admin_init', array(&$this, '_sop') );
            add_action('admin_menu', array(&$this, '_rp'));
            add_filter('plugin_action_links', array(&$this, '_psl'), 10, 2);
            add_action('admin_print_scripts', array(&$this,'_ejs'));
            add_action('admin_print_styles', array(&$this,'_ecs'));	
            add_filter('admin_icon', array(&$this, '_aic'));				
            add_action('show_user_profile', array(&$this,'_g_gup'));
            add_action('edit_user_profile', array(&$this,'_g_gup'));
            add_action('personal_options_update', array(&$this,'_puou'));
            add_action('edit_user_profile_update', array(&$this,'_puou'));
            if(get_option('blog_public') == '0'){
                add_action('admin_footer', array(&$this,'_pbe'));
            }
        }
        function _sop() {
            register_setting('b2_seo_global_options', 'b2_seo');
            register_setting('b2_seo_global_options_t', 'b2_seo_t');
            register_setting('b2_seo_global_options_p', 'b2_seo_p');
            register_setting('b2_seo_global_options_i', 'b2_seo_i');
            register_setting('b2_seo_global_options_n', 'b2_seo_n');
            register_setting('b2_seo_global_options_r', 'b2_seo_r');
            register_setting('b2_seo_global_options_3', 'b2_seo_3');
            register_setting('b2_seo_global_options_b', 'b2_seo_b');
            register_setting('b2_seo_global_options_h', 'b2_seo_h');
            register_setting('b2_seo_global_options_w', 'b2_seo_w');
            register_setting('b2_seo_global_options_f', 'b2_seo_f');
            register_setting('b2_seo_global_options_c', 'b2_seo_c');
            register_setting('b2_seo_global_options_e', 'b2_seo_e');
        }
        function _pbe() {
            $_os = get_option('b2_seo');
            if(isset($_os['_ipb_']) && $_os['_ipb_'] == '1' )
                return;
            echo "<div id='message' class='error'>";
            echo "<p><strong>Warning: You're blocking robots!!</strong> You must set your blog visible to everyone. Go to <a href='options-privacy.php'>Settings</a>.</p></div>";
        }
        function _as() {
        ?>
            <div class="postbox-container" style="margin-left: 10px;width:30%;">
                <div class="metabox-holder">	
                    <div class="meta-box-sortables">
                        <?php
                            $this->_wp2ns();                            $this->_wpguid();                            $this->_wp2np();
                        ?>
                    </div>
                    <br/><br/><br/>
                </div>
            </div>
        <?php
        }

        function _stc($_ct, $_h = false, $_f = true, $_o = 'b2_seo_global_options', $_k = 'b2_seo', $_fl = false){
            ?>
            <div class="wrap">
                <?php 
                if((isset($_GET['updated']) && $_GET['updated'] == 'true') || (isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true')){
                    $_m = 'Configurations updated';
                    if(function_exists('w3tc_pgcache_flush')){
                        w3tc_pgcache_flush();
                        $_m .= ' &amp; W3 Total Cache Page Cache flushed';
                    }else if(function_exists('wp_cache_clear_cache()')){
                        wp_cache_clear_cache();
                        $_m .= ' &amp; WP Super Cache flushed';
                    }
                    echo '<div id="message" style="width:94%;" class="message updated"><p><strong>'.$_m.'.</strong></p></div>';
                }
                $_x = get_option('b2_seo');
                if(!empty($_x) && is_array($_x)){
                    /* Authenticate!! */
                }
                ?>
                <a href="http://b2foundry.com/"><div id="b2-icon" style="background: url(<?php echo B2_SEO_URL; ?>/css/images/b2_32.png) no-repeat;" class="icon32"><br /></div></a>
                <h2><?php echo "B2 SEO: ".$_ct; ?></h2>
                <div class="postbox-container" style="width:68%;">
                    <div class="metabox-holder">	
                        <div class="meta-box-sortables">
            <?php
            if ($_f) {
                echo '<form action="'.admin_url('options.php').'" method="post" id="seo-configurations"' . ($_fl ? ' enctype="multipart/form-data"' : '') . '>';
                settings_fields($_o); 
                $this->_cp = $_k;
            }
        }
        
        function _sbc($_ct, $_bs = true, $_up=false) {
            if ($_bs) {
            ?>
                <div class="submit"><input type="submit" class="button-primary" name="submit" value="<?php echo "Update ".$_ct." Configurations"; ?>" /></div>
            <?php } ?>
            <?php if($_up){ echo $this->_hi('_updfxx_','x1097bc');} ?>
                        </form>
                        </div>
                    </div>
                </div>
                <?php $this->_as(); ?>
            </div>				
            <?php
        }
        
        function update_meta_key($old_key, $new_key, $replace_key = false) {
            global $wpdb;
            $old_keys = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '$old_key'");
            foreach ($old_keys as $key) {
                $exists = $wpdb->get_var("SELECT count(*) FROM $wpdb->postmeta WHERE meta_key = '$new_key' AND post_id = ".$old->post_id);
                if ($exists == 0)
                    $wpdb->query("INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) VALUES (".$key->post_id.",'".$new_key."','".addslashes($key->meta_value)."')");
            }
            if ($replace_key){
                $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '$old_key'");
            }
        }
        
        function delete_meta($key) {
            global $wpdb;
            $wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '$key'");
        }
        
        function _g_gsp(){
            $_os = _gso();
            $this->_stc('Dashboard', false);
            ksort($_os);
            $_h = '';
            $_x_ = get_option('permalink_structure');
            if(!$_x_ || (strpos(get_option('permalink_structure'), '%postname%') === false && !isset($_os['_ipm_']))){
                $_h .= '<p id="_ipm_" class="wrong">'
                .'Oops, seems you have not set your permalink structures. Consider setting '
                .'<a href="'.admin_url('options-permalink.php').'">Permalink Settings</a>'
                .'</p>';
            }
            if(get_option('page_comments') && $_os['_ipc_'] == ''){
                $_h .= '<p id="_ipc_" class="wrong">'
                .'Comments paging is enabled. It is not a common practice in general. Please disable it. '
                .'<a href="'.admin_url('options-discussion.php').'">Comments Settings</a>'
                .'</p>';
            }
            if ($_h != '')
                $this->_cpb('Settings/Suggestions','Wordpress Settings Suggestions',$_h); 
            $_h  = $this->_hn('_ipb_');
            $_h .= $this->_hn('_ipc_');
            $_h .= $this->_hn('_ipm_');						//Keywords are allowed by default. Hide it!
            //$_h .= $this->_cb('_umkw_', 'Allow <code>meta</code> keywords tag?');
            $_h .= $this->_cb('_dds_', 'Disable date in snippet preview for posts');
            $_h .= '<p><strong>Hide SEO Metabox in the following post types:</strong></p>';
            foreach(get_post_types() as $_t){
                if(in_array($_t, array('revision','nav_menu_item','post_format')))
                    continue;
                $_h .= $this->_cb('_'.$_t.'-h-eb_', $_t);
            }	
            $this->_cpb('_g_gsp','SEO Settings',$_h);
            do_action('g', $this);
            $this->_sbc('');
        }
        function _g_ttp(){
            $this->_stc('Title Tag Settings', false, true, 'b2_seo_global_options_t', 'b2_seo_t');
            $_os = _gso();
            $_h = '<p>In order to enable B2 SEO to modify your site titles, the <code>title</code> tag in your <code>header.php</code> file should look like this:</p>';
            $_h .= '<pre>&lt;title&gt;&lt;?php wp_title(&#x27;&#x27;); ?&gt;&lt;/title&gt;</pre>';
            $_h .= '<p>Otherwise enable a forceful rewrite of your titles by checking the checkbox below.</p>';
            $_h .= $this->_cb('_rtf_','Rewrite titles forcefully');
            $_h .= '<h4 class="big">Individual Pages</h4>';
            $_h .= '<p>You may want to set titles and information for individual pages and posts.  To do that fill, out the B2 SEO area on that page or post.  To create a template to use on all other pages and posts, fill out the area below</p>';
            if('posts' == get_option('show_on_front')){
                $_h .= '<h4>Landing Page (Latest Blog Posts)</h4>';
                $_h .= $this->_ti('_ht_','Title');
                $_h .= $this->_ta('_hmd_','Meta description');
                //if(isset($_os['_umkw_']) && $_os['_umkw_'])				//Metakeywords are allowed sitewide!!
                $_h .= $this->_ta('_hmkw_','Meta keywords');
            }else{
                $_h .= '<h4>Landing Page (Home Page)</h4>';
                $_h .= '<p>You can set the templates for the front page (' . get_option('page_on_front') . ')by <a href="'.get_edit_post_link(get_option('page_on_front')).'">editing the page SEO settings</a>.</p>';
                if(is_numeric(get_option('page_for_posts'))){
                    $_l = get_edit_post_link(get_option('page_for_posts'));
                    if($_l != ''){
                        $_h .= '<p>You can set the templates for the front page (' . get_option('page_on_front') . ')by <a href="'.$link.'">editing the page SEO settings</a>.</p>';
                    }
                }
            }
            foreach(get_post_types() as $_t){
                if(in_array($_t, array('revision','nav_menu_item','post_format')))
                    continue;
                if($_t == 'attachment')
                    continue;
                $_h .= '<h4 id="'.$_t.'">'.ucfirst($_t).'</h4>';
                $_h .= $this->_ti('_'.$_t.'-t_','Title');
                $_h .= $this->_ta('_'.$_t.'-m-d_','Meta description');
                //if(isset($_os['_umkw_']) && $_os['_umkw_'])				//Metakeywords are allowed by default!!
                $_h .= $this->_ta('_'.$_t.'-m-k_','Meta keywords');
                $_h .= '<br/>';
            }
            $_h .= '<br/>';
            foreach(get_taxonomies() as $_x){
                if(in_array($_x, array('link_category','nav_menu')))
                    continue;				
                $_h .= '<h4>'.ucfirst($_x).'</h4>';
                $_h .= $this->_ti('_'.$_x.'-t_','Title');
                $_h .= $this->_ta('_.'.$_x.'-m-d_','Meta description');
                //if(isset($_os['_umkw_']) && $_os['_umkw_'])				//Metakeywords are allowed by default!!
                $_h .= $this->_ta('_'.$_x.'-m-k_','Meta keywords');
                $_h .= '<br/>';				
            }
            $_h .= '<br/>';
            $_h .= '<h4>Author Archives</h4>';
            $_h .= $this->_ti('_author-t_','Title');
            $_h .= $this->_ta('_author-m-d_','Meta description');
            //if(isset($_os['_umkw_']) && $_os['_umkw_'])			//Metakeywords are allowed by default
            $_h .= $this->_ta('_author-m-k_','Meta keywords');
            $_h .= '<br/>';
            $_h .= '<h4>Date Archives</h4>';
            $_h .= $this->_ti('_archive-t_','Title');
            $_h .= $this->_ta('_archive-m-d_','Meta description');
            $_h .= '<br/>';
            $_h .= '<h4>Search Pages</h4>';
            $_h .= $this->_ti('_search-t_','Title');
            $_h .= '<h4>404 Pages</h4>';
            $_h .= $this->_ti('_404-t_','Title');
            $_h .= '<br class="clear"/>';
                
            $this->_cpb('_g_ttp','Title Tag Settings', $_h); 
                
            $_h = '
                <p>Reference templates</p>
                <table class="ref">
                    <tr>
                        <th>%%date%%</th>
                        <td>Date of Post/Page</td>
                    </tr>
                    <tr class="alt">
                        <th>%%title%%</th>
                        <td>Title of Post/Page</td>
                    </tr>
                    <tr>
                        <th>%%sitename%%</th>
                        <td>Site Name</td>
                    </tr>
                    <tr class="alt">
                        <th>%%sitedesc%%</th>
                        <td>Site Tagline/Description</td>
                    </tr>
                    <tr>
                        <th>%%excerpt%%</th>
                        <td>Excerpt of Post/Page (Generates automatically if it doesn\'t exist)</td>
                    </tr>
                    <tr class="alt">
                        <th>%%excerpt_noauto%%</th>
                        <td>Excerpt of Post/Page (Won\'t generate automatically if it doesn\'t exist)</td>
                    </tr>
                    <tr>
                        <th>%%tag%%</th>
                        <td>Tags</td>
                    </tr>
                    <tr class="alt">
                        <th>%%category%%</th>
                        <td>Post Categories</td>
                    </tr>
                    <tr>
                        <th>%%category_description%%</th>
                        <td>Category Description</td>
                    </tr>
                    <tr class="alt">
                        <th>%%tag_description%%</th>
                        <td>Tag Description</td>
                    </tr>
                    <tr>
                        <th>%%term_description%%</th>
                        <td>Term Description</td>
                    </tr>
                    <tr class="alt">
                        <th>%%term_title%%</th>
                        <td>Term Title</td>
                    </tr>
                    <tr>
                        <th>%%modified%%</th>
                        <td>Post/Page Modification Date</td>
                    </tr>
                    <tr class="alt">
                        <th>%%id%%</th>
                        <td>Post/Page ID</td>
                    </tr>
                    <tr>
                        <th>%%name%%</th>
                        <td>Post/Page Author\'s Name</td>
                    </tr>
                    <tr class="alt">
                        <th>%%userid%%</th>
                        <td>Post/Page Author\'s user id</td>
                    </tr>
                    <tr>
                        <th>%%searchphrase%%</th>
                        <td>Search Phrase</td>
                    </tr>
                    <tr class="alt">
                        <th>%%currenttime%%</th>
                        <td>Current Time</td>
                    </tr>
                    <tr>
                        <th>%%currentdate%%</th>
                        <td>Current Date</td>
                    </tr>
                    <tr class="alt">
                        <th>%%currentmonth%%</th>
                        <td>Current Month</td>
                    </tr>
                    <tr>
                        <th>%%currentyear%%</th>
                        <td>Current Year</td>
                    </tr>
                    <tr class="alt">
                        <th>%%page%%</th>
                        <td>Current Page Number</td>
                    </tr>
                    <tr>
                        <th>%%pagetotal%%</th>
                        <td>Current Page Total</td>
                    </tr>
                    <tr>
                        <th>%%caption%%</th>
                        <td>Attachment Caption</td>
                    </tr>
                </table>';
            $this->_cpb('_g_ttp_r','Title Templates', $_h); 
            $this->_sbc('Title Tag');
        }
        function _g_plp() {
            if(isset($_GET['settings-updated'])){
                delete_option('rewrite_rules');
            }
            $this->_stc('Permalinks', true, true, 'b2_seo_global_options_p', 'b2_seo_p');
            $_h = $this->_cb('_rcb_','Remove category base <code>/category/</code>) from the category URL.');
            $_h .= $this->_cb('_tsh_','Put a trailing slash on all category and tag URLs');
            $_h .= '<p class="desc">If there is <code>.html</code> at the end of you links, or anything else but a / on the end, this will force WordPress to add a trailing slash to non-post pages.</p>';
            $_h .= $this->_cb('_rat_','Redirect attachments URLs to parent post URLs.');
            $_h .= '<p class="desc">Attachments to posts are stored as posts. This means they have their own accessible URLs. Checking this option will force the attachment\'s URL to point to the post URL it belong to.</p>';
            $_h .= $this->_cb('_cln_','Redirect untidy links to pretty permalinks.');
            $this->_cpb('_g_plp','Permalink Settings',$_h); 
            $this->_sbc('Permalinks');
        }
        function _g_inp() {
            $this->_stc('Indexing', true, true, 'b2_seo_global_options_i', 'b2_seo_i');
            $_h = '<p>You can specify the section that you want to block search engines from indexing.</p>';
            $_h .= $this->_cb('_sr_','Search Results');
            $_h .= '<p class="desc">Block search engines from indexing search results.</p>';
            $_h .= $this->_cb('_li_','Login/Register Pages');
            $_h .= '<p class="desc">Block login/register pages from being indexed</p>';
            $_h .= $this->_cb('_ad_','Admin Pages');
            $_h .= '<p class="desc">Block admin pages from being indexed</p>';
            $_h .= $this->_cb('_sp_','Subpages from Home/Landing Page');
            $_h .= '<p class="desc">Block search engines from indexing sub pages.</p>';
            $_h .= $this->_cb('_nia_','Authors Archives');
            $_h .= '<p class="desc">Block search engines from indexing author archives.</p>';
            $_h .= $this->_cb('_nid_','Dated Archives');
            $_h .= '<p class="desc">Block search engines from indexing date based archives.</p>';
            $_h .= $this->_cb('_nie_','Category Archives');
            $_h .= '<p class="desc">Block Category Archive indexing</p>';
            $_h .= $this->_cb('_nit_','Tag Archives');
            $_h .= '<p class="desc">Block Tag Archive indexing</p>';
            $this->_cpb('g_inp','Indexing Rules',$_h);
            $this->_sbc('Indexing');
	}
        function _g_nfp(){
            $this->_stc('Follow/NoFollow Rules', true, true, 'b2_seo_global_options_n', 'b2_seo_n');
            $_h = $this->_cb('_nfm_','Nofollow Login/Registration Pages');
            $_h .= $this->_cb('_nfcl_','Nofollow Comment Links');
            $_h .= $this->_cb('_rmw_','Nofollow links in the Meta Widget');
            $this->_cpb('_g_nfp','NoFollow Settings',$_h);
            $this->_sbc('Follow/NoFollow Rules');
        }
        function _g_rsp(){
            $this->_stc('Robot Settings', true, true, 'b2_seo_global_options_r', 'b2_seo_r');
            $_h = '<p>You can individually add these settings on each each page/post from edit screens. Here you can do sitewide settings. (Not Recommended)</p>';
            $_h .= $this->_cb('_ndp_','Add <code>noodp</code> robot tag sitewide');
            $_h .= $this->_cb('_nyd_','Add <code>noydir</code> robot tag sitewide');
            $_h .= $this->_cb('_nsp_','Add <code>nosnippet</code> robot tag sitewide');
            $_h .= $this->_cb('_nar_','Add <code>noarchive</code>robot tag sitewide');
            $this->_cpb('_g_rsp','Robot Tag Settings',$_h); 
            $this->_sbc('Robot Settings');
        }
        function _g_301p(){
            $this->_stc('301 Redirects', true, true, 'b2_seo_global_options_3', 'b2_seo_3');
            $_h = $this->_cb('_dsa_','301 Redirect Author Archives to default to the home page');
            $_h .= '<p class="desc">If your theme does not have a template for author archives, you can simply redirect an author\'s link to the home page.</p>';
            $_h .= $this->_cb('_dsd_','301 Redirect Date Based Archives to default to the home page');
            $_h .= '<p class="desc">If your theme does not have a template for date based archives, you can simply redirect a date archive link to the home page.</p>';
            $this->_cpb('_g_301p','301 Redirects',$_h);
            $this->_sbc('301 Redirects');
        }
        function _g_xsp(){
        }
        function _g_bcp() {
            $this->_stc('Breadcrumbs', false, true, 'b2_seo_global_options_b', 'b2_seo_b');
            $_h = $this->_cb('_tbc_','Enable Breadcrumbs');
            $_h .= '<br/>';
            $_h .= $this->_ti('_bsp_','Separator');
            $_h .= $this->_ti('_hbc_','Alias for the Homepage');
            $_h .= $this->_ti('_pbc_','Prefix for the breadcrumb path');
            $_h .= $this->_ti('_apbc_','Prefix for Archive breadcrumbs');
            $_h .= $this->_ti('_spbc_','Prefix for Search Page breadcrumbs');
            $_h .= $this->_ti('_4pbc_','Alias for 404 Page');
            $_h .= $this->_cb('_rbp_','Remove Blogroll from breadcrumbs');
            $_h .= '<br/><br/>';
            $_h .= '<strong>Taxonomy to show in breadcrumbs:</strong><br/>';
            foreach(get_post_types() as $_t){
                if (in_array($_t, array('revision', 'attachment', 'nav_menu_item', 'post_format')))
                    continue;
                $_x = get_object_taxonomies($_t);
                if(count($_x) > 0) {
                    $_vs = array(0 => 'None');
                    foreach(get_object_taxonomies($_t) as $_x){
                            $_xx = get_taxonomy($_x);
                            $_vs[$_x] = $_xx->labels->singular_name;
                    }
                    $_j = get_post_type_object($_t);
                    $_h .= $this->_st('_m-t-p_t-'.$_t.'_', $_j->labels->name, $_vs);					
                }
            }
            $_h .= '<br/>';
            $_h .= $this->_cb('_bcbl_','Bold last page in the breadcrumb');
            $_h .= '<br class="clear"/>';
            $_h .= '<h4>Usage</h4>';
            $_h .= '<p>Put this code into your theme anywhere you want to show the breadcruumbs:</p>';
            $_h .= '<pre>&lt;?php if(function_exists(&#x27;b2_breadcrumbs&#x27;)){
                        b2_breadcrumbs(&#x27;&lt;p id=&quot;breadcrumbs&quot;&gt;&#x27;,&#x27;&lt;/p&gt;&#x27;);
            } ?&gt;</pre>';
            $this->_cpb('_g_bcp','Breadcrumbs Settings',$_h); 
            $this->_sbc('Breadcrumbs');
	}
        function _g_chp(){
            $this->_stc('Head Tag Cleaner', true, true, 'b2_seo_global_options_h', 'b2_seo_h');
            $_h = '<p>You can clean your <code>&lt;head&gt;</code> tag.</p>';
            $_h .= $this->_cb('_hrsd_','Hide RSD Links');
            $_h .= $this->_cb('_hwlm_','Hide WLW Manifest Links');
            $_h .= $this->_cb('_hwpg_','Hide WordPress Generator');
            $_h .= $this->_cb('_hir_','Hide Index Relation Links');
            $_h .= $this->_cb('_hsr_','Hide Start Relation Links');
            $_h .= $this->_cb('_hpnp_','Hide Previous/Next Post Links');
            $_h .= $this->_cb('_hsl_','Hide Shortlink for posts');
            $_h .= $this->_cb('_hfl_','Hide RSS Links');
            $this->_cpb('_g_chp','Clean &lt;head&gt; Section',$_h);
            $this->_sbc('Head Tag Cleaning');
        }
        function _g_wbp(){
            $this->_stc('Webmaster Tools', false, true, 'b2_seo_global_options_w', 'b2_seo_w');
            $_h = '<p>Enter verification codes from different webmaster tools.</p>';
            $_h .= $this->_ti('_gv_', '<a target="_blank" href="https://www.google.com/webmasters/tools/dashboard?hl=en&amp;siteUrl='.urlencode(get_bloginfo('url')).'%2F">Google Webmaster Tools</a>');
            $_h .= $this->_ti('_yv_','<a target="_blank" href="https://siteexplorer.search.yahoo.com/mysites">Yahoo! Site Explorer</a>');
            $_h .= $this->_ti('_bv_','<a target="_blank" href="http://www.bing.com/webmaster/?rfp=1#/Dashboard/?url='.str_replace('http://','',get_bloginfo('url')).'">Bing Webmaster Tools</a>');
            $this->_cpb('_wbt_','Webmaster Tools',$_h);
            $this->_sbc('Webmaster Tool');
        }
        function _g_fdp() {
            $_os = _gso();
            $this->_stc('RSS Settings', false, true, 'b2_seo_global_options_f', 'b2_seo_f');
            $_h = $this->_cb('_cmf_','<code>noindex</code> comments RSS Feed');
            $_h .= $this->_cb('_alf_','<code>noindex</code> <strong>All</strong> RSS feeds');
            $_h .= $this->_cb('_pif_','Ping Search Engines with feed on new post');
            $this->_cpb('_g_fdp_1','RSS Feed Settings',$_h); 			
            
            $_h = '<p>'."You can put custom html into your feed such as your blog links to let search engines identify the original source of the contents in case someone steals your content by coping and pasting your feed into their blog or website".'</p>';
            $_r = array();
            $_rbf = '';
            if(isset($_os['_rbf_']))
                $_rbf = stripslashes(htmlentities($_os['_rbf_']));
    
            $_raf = '';
            if(isset($_os['_raf_']))
                $_raf = stripslashes(htmlentities($_os['_raf_']));
            
            $_r[] = array(
                "_i" => "_rbf_",
                "_l" => "Contents before post in the feed",
                "_d" => "(HTML allowed)",
                "_c" => '<textarea cols="50" rows="5" id="_rbf_" name="b2_seo_f[_rbf_]">'.$_rbf.'</textarea>',
            );
            $_r[] = array(
                "_i" => "_raf_",
                "_l" => "Contents after post in the feed",
                "_d" => "(HTML allowed)",
                "_c" => '<textarea cols="50" rows="5" id="_raf_" name="b2_seo_f[_raf_]">'.$_raf.'</textarea>',
            );
            $_r[] = array(
                "_l" => 'Help',
                "_c" => '<p>Use the following variables within the content, to replace with original values:</p>'.
                '<ul>'.
                '<li><strong>%%POSTLINK%%</strong> : Link to the post</li>'.
                '<li><strong>%%BLOGLINK%%</strong> : Link to your site</li>'.
                '<li><strong>%%BLOGDESCLINK%%</strong> : Your site\'s name and description</li>'.
                '</ul>'
            );
            $this->_cpb('_g_fdp_2','Custom Contents in the RSS Feed',$_h.$this->_ft($_r));
            $this->_sbc('RSS');
        }

        
        function _g_cip(){
            $this->_stc('Custom Code Inserter', true, true, 'b2_seo_global_options_c', 'b2_seo_c');
            $_h = $this->_ta('_htc_','&lt;head&gt; Tag');
            $_h .= '<p class="desc">Enter the code you want to insert into the <code>&lt;head&gt;</code> tag.</p>';
            $_h .= $this->_ta('_bitc_','Before Item\'s Contents');
            $_h .= '<p class="desc">Enter the code you want to insert before any item\'s contents.</p>';
            $_h .= $this->_ta('_aitc_','After Item\'s Contents');
            $_h .= '<p class="desc">Enter the code you want to insert after any item\'s contents.</p>';
            $_h .= $this->_ta('_ftc_','Before &lt;/body&gt; Tag (Footer)');
            $_h .= '<p class="desc">Enter the code you want to insert in the footer before <code>&lt;/body&gt;</code> tag.</p>';
            $this->_cpb('_g_cip','Custom Code Inserter',$_h);
            $this->_sbc('Custom Code');
        }
        function _g_pap(){
            
        }
        function _g_fep(){
            $this->_stc('File Editor', true, true, 'b2_seo_global_options_e', 'b2_seo_e');
            $_h = '<div id="message" style="width:94%;" class="error"><p><strong>Note:</strong><br />Editing the <strong><code>robots.txt</code></strong> file incorrectly can block search engines from your site. Also incorrectly edited <strong><code>.htaccess</code></strong> file will disable your entire website. DON\'T EDIT IF YOU ARE NOT FAMILIAR WITH THESE FILES.</p></div>';
            $_h .= $this->_fe('_hrw_','.htaccess','.htaccess');
            $_h .= $this->_fe('_rbt_','robots.txt','robots.txt');
            $this->_cpb('_g_fep','File Editor',$_h);
            $this->_sbc('.htaccess &amp; robots.txt file',true,true);
        }
        function _g_bkp(){
            $this->_stc('Backup/Restore Settings', false, false);
            $_h .= '<strong>Backup</strong><br/>';
            $_h .= '<form method="post">';
            $_h .= '<p>Backup your B2 SEO settings.</p>';
            $_h .= '<input type="submit" class="button" name="b2_seo_exp" value="Backup Settings"/>';
            $_h .= '</form>';
            if ( isset($_POST['b2_seo_exp']) ) {
                $_itm_ = false;
                $_u = _exps();
                if($_u){
                    $_h .= '<script type="text/javascript">
                        document.location = \''.$_u.'\';
                    </script>';
                }else{
                    $_h .= 'An Error Occured: '.$_u;
                }
            }
            $_h .= '<br class="clear"/><br/><strong>Restore</strong><br/>';
            if(!isset($_FILES['_sif_']) || empty($_FILES['_sif_']) ) {
                $_h .= '<p>Restore by locating <code>b2seo.zip</code> and clicking Restore settings:</p>';
                $_h .= '<form method="post" enctype="multipart/form-data">';
                $_h .= '<input type="file" name="_sif_"/>';
                $_h .= '<input type="hidden" name="action" value="wp_handle_upload"/>';
                $_h .= '<input type="submit" class="button" value="Restore"/>';
                $_h .= '</form>';
            } else {
                $_f = wp_handle_upload($_FILES['_sif_']);
                if(isset($_f['file'] ) && !is_wp_error($_f)){
                    require_once (ABSPATH . 'wp-admin/includes/class-pclzip.php');
                    $_z = new PclZip($_f['file']);
                    $_uz = $_z->extract(PCLZIP_OPT_PATH,'restore');
                    if($_uz[0]['stored_filename'] == 'b2seo.ini'){
                        if(file_exists($_uz[0]['filename'])){
                        $_ss = parse_ini_file($_uz[0]['filename'], true);
                        foreach($_ss as $_k => $_v) {
                            if($_k != 'b2_seo_m') {
                                update_option($_k, $_v);
                            } else {
                                update_option($_k, json_decode(urldecode($_v['b2_seo_m']), true));
                            }
                        }
                        $_h .= '<p><strong>Restored successfully.</strong></p>';
                        }else{
                            $_h .= "<p><strong>File: " . $_uz[0]['filename'] . " doesn't exist";
                        }
                    } else {
                        $_h .= '<p><strong>Error occured while restoring. Please try again later.</strong></p>';
                    }
                } else {
                    if(is_wp_error($_f))
                        $_h .= '<p><strong>Restore failed: '.$_f['error'].'</strong></p>';
                    else
                        $_h .= '<p><strong>Restore failed: Can\'t upload</strong></p>';
                }
            }
            $this->_cpb('_g_bkp','File Editor',$_h);
            $this->_sbc('Backup/Restore',false);
        }
        function _g_gup($_u){
            if(!current_user_can('edit_users'))
                return;
            $_os = _gso();
            ?>
            <h3 id="seo">B2 SEO settings</h3>
            <table class="form-table">
                <tr>
                    <th>Author Page Title</th>
                    <td><input class="regular-text" type="text" name="_ttl_" value="<?php echo esc_attr(get_the_author_meta('_ttl_', $_u->ID));?>"/></td>
                </tr>
                <tr>
                    <th>Meta description for Author page</th>
                    <td><textarea rows="3" cols="30" name="_mds_"><?php echo esc_html(get_the_author_meta('_mds_', $_u->ID));?></textarea></td>
                </tr>
            <?php //if(isset($_os['_umkw_']) && $_os['_umkw_']){ Metakeywords are allowed by default ?>
                <tr>
                    <th>Author Meta Keywords</th>
                    <td><input class="regular-text" type="text" name="_mkw_" value="<?php echo esc_attr(get_the_author_meta('_mkw_', $_u->ID));?>"/></td>
                </tr>
            <?php //} ?>
            </table>
            <br/><br/>
            <?php
        }
        function _puou($_uid) {
            update_user_meta($_uid, '_ttl_', (isset($_POST['_ttl_']) ? $_POST['_ttl_'] : ''));
            update_user_meta($_uid, '_mds_', (isset($_POST['_mds_']) ? $_POST['_mds_'] : ''));
            update_user_meta($_uid, '_mkw_', (isset($_POST['_mkw_']) ? $_POST['_mkw_'] : ''));
        }
        
    }
    $b2_a = new b2_a();
}
?>