<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$user = 'root';
$action = GetVars('action', 'GET');
if (!$zbp->CheckRights($user)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('CommentUA')) {$zbp->ShowError(48);die();}

$blogtitle = 'CommentUA';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>

<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle;?></div>
  <div class="SubMenu"><?php echo CommentUA_SubMenu($action);?></div>
  <div id="divMain2">
<?php
switch ($action) {
	case 'help':
		?>
			 <p>&nbsp;</p>
    <p>基于开源库<a href="https://github.com/zsxsoft/php-useragent" target="_blank">https://github.com/zsxsoft/php-useragent</a>所写。</p>
    <p>@license GNU/GPL http://www.gnu.org/copyleft/gpl.html</p>
    			<?php
	break;
	case 'test':
		?>
			    <p>将待测试UA以test.txt放在插件目录下，插件便会自动读取</p>
    <table border="1" class="tableFull tableBorder tableBorder-thcenter" width="100%" style="word-break:break-all;">
      <tr>
        <th>Browser</th>
      <th>OS</th>
      <th>Device</th>
      <th>Platform</th>
      <th>UserAgent</th>
      </tr>
	<?php
	$filepath = COMMENTUA_PATH . 'test.txt';
		if (is_file($filepath)) {
			$file = explode("\n", file_get_contents($filepath));
			CommentUA_include();
			foreach ($file as $value) {
				$useragent = UserAgentFactory::analyze(trim($value));

				?>
	      <tr>
      <td>
        <img src="<?php echo $useragent->browser['image']?>"/><?php echo $useragent->browser['title']?></td>
      <td>
        <img src="<?php echo $useragent->os['image']?>"/><?php echo $useragent->os['title']?></td>
      <td>
        <img src="<?php echo $useragent->device['image']?>"/><?php echo $useragent->device['title']?></td>
      <td>
        <img src="<?php echo $useragent->platform['image']?>"/><?php echo $useragent->platform['title']?></td>
      <td>
        		<?php echo $useragent->useragent?></td>
    </tr>
	    
    			<?php
	}	?></table>
  <?php
}
	break;
	default:
		$comment = new Comment;
		$comment->Agent = GetVars('HTTP_USER_AGENT', 'SERVER');

		?>
			    <table border="1" class="tableFull tableBorder tableBorder-thcenter" width="100%" style="word-break:break-all;">
      <tr>
        <th width="30%">标签</th>
        <th>详细</th>
        <th width="50%">事例</th>
      </tr>
      <tr>
        <td>{$comment.CommentUA_GetUserAgent()}</td>
        <td>初始化评论User-Agent使用</td>
        <td>			<?php $comment->CommentUA_GetUserAgent();?>该标签必须放在模板comment.php的最顶部位置。</td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['browser']['img_16']}</td>
        <td>用于加载浏览器图标的地址，16x16</td>
        <td><img src="			<?php echo $comment->CommentUA['browser']['img_16'];?>" alt="<?php echo $comment->CommentUA['browser']['title'];?>" width="16" height="16"/></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['browser']['img_24']}</td>
        <td>用于加载浏览器图标的地址，24x24</td>
        <td><img src="			<?php echo $comment->CommentUA['browser']['img_24'];?>" alt="<?php echo $comment->CommentUA['browser']['title'];?>" width="24" height="24"/></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['browser']['title']}</td>
        <td>用于加载浏览器名称和版本号</td>
        <td>			<?php echo $comment->CommentUA['browser']['title'];?></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['browser']['link']}</td>
        <td>用于加载浏览器厂商地址</td>
        <td><a href="			<?php echo $comment->CommentUA['browser']['link'];?>"><?php echo $comment->CommentUA['browser']['title'];?></a></td>
      </tr><tr>
        <td>{$comment.CommentUA['browser']['all_16']}</td>
        <td>组合标签(16x16)</td>
        <td>			<?php echo $comment->CommentUA['browser']['all_16']?></td>
      </tr><tr>
        <td>{$comment.CommentUA['browser']['all_24']}</td>
        <td>组合标签(24x24)</td>
        <td>			<?php echo $comment->CommentUA['browser']['all_24']?></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['platform']['img_16']}</td>
        <td>用于加载操作系统图标的地址，16x16</td>
        <td><img src="			<?php echo $comment->CommentUA['platform']['img_16'];?>" alt="<?php echo $comment->CommentUA['platform']['title'];?>" width="16" height="16"/></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['platform']['img_24']}</td>
        <td>用于加载操作系统图标的地址，24x24</td>
        <td><img src="			<?php echo $comment->CommentUA['platform']['img_24'];?>" alt="<?php echo $comment->CommentUA['platform']['title'];?>" width="24" height="24"/></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['platform']['title']}</td>
        <td>用于加载操作系统名称和版本号</td>
        <td>			<?php echo $comment->CommentUA['platform']['title'];?></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['platform']['link']}</td>
        <td>用于加载操作系统厂商地址</td>
        <td><a href="			<?php echo $comment->CommentUA['platform']['link'];?>"><?php echo $comment->CommentUA['platform']['title'];?></a></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['platform']['all_16']}</td>
        <td>组合标签(16x16)</td>
        <td>			<?php echo $comment->CommentUA['platform']['all_16']?></td>
      </tr><tr>
        <td>{$comment.CommentUA['platform']['all_24']}</td>
        <td>组合标签(24x24)</td>
        <td>			<?php echo $comment->CommentUA['platform']['all_24']?></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['all_16']}</td>
        <td>组合x2标签(16x16)</td>
        <td>			<?php echo $comment->CommentUA['all_16']?></td>
      </tr>
      <tr>
        <td>{$comment.CommentUA['all_24']}</td>
        <td>组合x2标签(24x24)</td>
        <td>			<?php echo $comment->CommentUA['all_24']?></td>
      </tr>
    </table>
    			<?php
	break;
}
?>
  </div>
</div>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
