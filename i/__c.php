<?php
if(!class_exists("b2_c")){
    class b2_c{
        var $_pt = '';
        var $_mt = '';
        var $_ic = '';
        var $_hk = '';
        var $_fl = '';
        var $_hm = '';
        var $_lv = 'manage_options';
        var $_ap = array('g', 't', 'p', 'i', 'n', 'r', '3', 'x', 'b', 'h', 'w', 'f', 'c', 'e', 'k');
        function b2_c(){
            /* Do nothing */
        }
        function _aic($_hk){
            if($_hk == $this->_hk){
                return B2_SEO_URL . $this->_ic;
            }
            return $_hk;
        }
        function _ejs() {
            global $pagenow;
            if($pagenow == 'admin.php' && isset($_GET['page']) && in_array($_GET['page'], $this->_ap)){

				wp_enqueue_script('postbox');
				wp_enqueue_script('dashboard');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('media-upload');
            }
        }
        function _ecs(){
            global $pagenow;
            if($pagenow == 'admin.php' && isset($_GET['page']) && in_array($_GET['page'], $this->_ap)){
		wp_enqueue_style('dashboard');
		wp_enqueue_style('thickbox');
		wp_enqueue_style('global');
		wp_enqueue_style('wp-admin');
                wp_enqueue_style('tools', B2_SEO_URL . 'css/tools.css');
            }
        }
        function _rp(){
	    add_menu_page($this->_pt, $this->_mt, $this->_lv, 'g', array(&$this,'_g_gsp'), B2_SEO_URL.'/css/images/b2_16.png');
            add_submenu_page('g','Title Tag Settings','Title Tag Settings',$this->_lv, 't', array(&$this,'_g_ttp'));
	    add_submenu_page('g','Permalinks','Permalinks',$this->_lv, 'p', array(&$this,'_g_plp'));
	    add_submenu_page('g','Indexing','Indexing',$this->_lv, 'i', array(&$this,'_g_inp'));
	    add_submenu_page('g','Follow/Nofollow Rules','Follow/Nofollow Rules',$this->_lv, 'n', array(&$this,'_g_nfp'));
	    add_submenu_page('g','Robot Settings','Robot Settings',$this->_lv, 'r', array(&$this,'_g_rsp'));
	    add_submenu_page('g','301 Redirects','301 Redirects',$this->_lv, '3', array(&$this,'_g_301p'));
	    add_submenu_page('g','Breadcrumbs','Breadcrumbs',$this->_lv, 'b', array(&$this,'_g_bcp'));
	    add_submenu_page('g','Clean Head Tag','Clean Head Tag',$this->_lv, 'h', array(&$this,'_g_chp'));
            add_submenu_page('g','Webmaster Tools','Webmaster Tools',$this->_lv, 'w', array(&$this,'_g_wbp'));
	    add_submenu_page('g','RSS Settings','RSS Settings',$this->_lv, 'f', array(&$this,'_g_fdp'));
	    add_submenu_page('g','Code Inserter','Code Inserter',$this->_lv, 'c', array(&$this,'_g_cip'));
	    add_submenu_page('g','File Editor','File Editor',$this->_lv, 'e', array(&$this,'_g_fep'));
	    add_submenu_page('g','Backup/Restore','Backup/Restore',$this->_lv, 'k', array(&$this,'_g_bkp'));
	    global $submenu;
            if(isset($submenu['g']))
                $submenu['g'][0][0] = 'Dashboard';
        }
        function _pu(){
            return admin_url('admin.php?page=g');
        }
        function _psl($_ls, $_f){
            static $_sp;
            if(empty($_sp))
                $_sp = $this->_fl;
            if($_f == $_sp){
                $_l = '<a href="' . $this->_pu() . '">Cofigurations</a>';
                array_unshift($_ls, $_l);
            }
            return $_ls;
        }
	function _cb($_i, $_l, $_lf = false, $_o = ''){
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
	    if(!isset($_os[$_i]))
		$_os[$_i] = false;
	    $_ol = '<label for="'.$_i.'">'.$_l.'</label>';
	    $_oi = '<input class="cb" type="checkbox" id="'.$_i.'" name="'.$_o.'['.$_i.']"'. checked($_os[$_i],'on',false).'/> ';
	    if($_lf) {
		$_h = $_ol . $_oi;
	    }else{
		$_h = $_oi . $_ol;
	    }
	    return $_h . '<br class="clear" />';
	}
	function _ti($_i, $_l, $_o = ''){
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
	    $_v = '';
	    if(isset($_os[$_i]))
		$_v = htmlspecialchars($_os[$_i]);
	    return '<label class="ti" for="'.$_i.'">'.$_l.':</label><input class="ti" type="text" id="'.$_i.'" name="'.$_o.'['.$_i.']" value="'.$_v.'"/>' . '<br class="clear" />';
	}
	function _ta($_i, $_l, $_o=''){
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
	    $_v = '';
	    if(isset($_os[$_i]))
		$_v = htmlspecialchars($_os[$_i]);
	    return '<label class="ta" for="'.$_i.'">'.$_l.':</label><textarea class="ta" type="text" id="'.$_i.'" name="'.$_o.'['.$_i.']" >'.$_v.'</textarea>'.'<br class="clear" />';
	}
	function _fe($_i, $_l,  $_f, $_o = ''){
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
            global $is_apache;
	    if($_f == '.htaccess'){
		if($is_apache){
		    $_hac = get_home_path() . $_f;
		    $_ex = file_exists($_hac);
		    $_wr = is_writable($_hac);
		    if($_ex && !$_wr){
			return '<div id="message" style="width:94%;" class="error"><p><code>.htaccess</code> file exists but is not writable. You can only edit the file once you have permissions set.</p></div>';
		    }
		    $_c = file_get_contents($_hac);
		    return '<label class="fe" for="'.$_i.'">'.$_l.':</label><textarea class="ta" type="text" id="'.$_i.'" name="'.$_o.'['.$_i.']" >'.$_c.'</textarea>'.'<br class="clear" />';
		}else{
		    return '<div id="message" style="width:94%;" class="error"><p>You are not using apache web server and thus there is no <code>.htaccess</code> file to edit.</p></div>';
		}
	    }else if($_f == 'robots.txt'){
		$_rb = get_home_path() . $_f;
		$_ex = file_exists($_rb);
		$_wr = is_writable($_rb);
		if(!$_ex){
		    return '<label class="fe" for="'.$_i.'">'.$_l.' (Create a new file):</label><textarea class="fe" type="text" id="'.$_i.'" name="'.$_o.'['.$_i.']" >'.$_c.'</textarea>'.'<br class="clear" />';
		}
		if($_ex && !$_wr){
		    return '<div id="message" style="width:94%;" class="error"><p><code>robots.txt</code> file exists but is not writable. You can only edit the file once you have permissions set.</p></div>';
		}
		$_c = file_get_contents($_rb);
		return '<label class="fe" for="'.$_i.'">'.$_l.':</label><textarea class="fe" type="text" id="'.$_i.'" name="'.$_o.'['.$_i.']" >'.$_c.'</textarea>'.'<br class="clear" />';
	    }
	}
	function _hi($_i, $_x = '', $_o = '') {
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
	    if(!empty($_x))
		$_v = $_x;
	    if(isset($_os[$_i]))
		$_v = htmlspecialchars($_os[$_i]);
	    return '<input class="hi" type="hidden" id="'.$_i.'" name="'.$_o.'['.$_i.']" value="'.$_v.'"/>';
	}
	function _st($_i, $_l, $_vs, $_o = ''){
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
	    $_h = '<label class="st" for="'.$_i.'">'.$_l.':</label>';
	    $_h .= '<select class="st" name="'.$_o.'['.$_i.']" id="'.$_i.'">';
	    foreach($_vs as $_v => $_l){
		$_s = '';
		if(isset($_os[$_i]) && $_os[$_i] == $_v)
		    $_s = 'selected="selected" ';
		if(!empty($_l))
		    $_h .= '<option '.$_s.'value="'.$_v.'">'.$_l.'</option>';
	    }
	    $_h .= '</select>';
	    return $_h . '<br class="clear"/>';
	}
	function _hn($_i, $_o = ''){
	    if($_o == ''){
		$_os = _gso();
		$_o = !empty($_o) ? $_o : $this->_cp;
	    }else{
		$_os = get_option($_o);
	    }
	    if(!isset($_os[$_i]))
		$_os[$_i] = '';
	    return '<input type="hidden" id="hidden_'.$_i.'" name="'.$_o.'['.$_i.']" value="'.$_os[$_i].'"/>';
	}
	function _ft($_rs){
	    $_h = '<table class="form-table">';
	    foreach ($_rs as $_r){
		$_h .= '<tr><th valign="top" scrope="row">';
		if(isset($_r['_i']) && $_r['_i'] != '')
		    $_h .= '<label for="'.$_r['_i'].'">'.$_r['_l'].':</label>';
		else
		    $_h .= $_r['_l'];
		if(isset($_r['_d']) && $_r['_d'] != '')
		    $_h .= '<br/><small>'.$_r['_d'].'</small>';
		$_h .= '</th><td valign="top">';
		$_h .= $_r['_c'];
		$_h .= '</td></tr>'; 
	    }
	    $_h .= '</table>';
	    return $_h;
	}
        function _cpb($_i, $_t, $_h){
        ?>
            <div id="<?php echo $_i; ?>" class="postbox">
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class="hndle"><span><?php echo $_t; ?></span></h3>
                <div class="inside">
                    <?php echo $_h; ?>
                </div>
            </div>
        <?php
        }
        function _wp2ns(){
            $_h = '<p>For any problems or suggestions please contact us at <a href="mailto:support@b2foundry.com?subject=[B2 SEO Plugin] Report">support@b2foundry.com</a>.</p>';
            $this->_cpb($this->_hk.'suggestions', 'Plugin Support', $_h);
        }				function _wpguid(){            $_h = '<a href="http://issuu.com/b2foundry/docs/b2foundry-b2seo-instructions?mode=window&backgroundColor=%23ffffff" target="_blank"><img style="width: 236px; height: auto; display: block; margin: 0 auto;" src="' . B2_SEO_URL . 'b2seo.png" /></a>';            $this->_cpb($this->_hk.'insmanual', 'B2 SEO Instruction Manual', $_h);		}
	function _wp2np(){
	    $this->_cpb('Plugins','B2 Foundry\'s Products','<ul>            <li><a href="http://www.b2foundry.com/products#b2-xml-sitemap-plugin" target="_blank">B2 XML Sitemap Generator</a></li>            <li><a href="http://issuu.com/b2foundry/docs/basic-seo?mode=window&backgroundColor=%23ffffff" target="_blank">Beginner\'s Guide to SEO for WordPress</a></li>            <li><a href="http://www.b2foundry.com" target="_blank">B2 Foundry\'s Web Design + Dev Services</a></li>            </ul>');
	}
        function _lt($_t, $_c, $_f = '&hellip;'){
            if(strlen($_t) > $_c) {
                $_t = substr($_t, 0, $_c);
                $_t = substr($_t, 0, -(strlen(strrchr( $_t,' '))));
                $_t .= $_f;
            }
            return $_t;
        }
    }
}
?>