<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * CatClaw 猫爪抓抓抓影视采集插件
 * 
 * @package CatClaw
 * @author jrotty
 * @version 1.7.1
 * @link https://blog.zezeshe.com/
 */
class CatClaw_Plugin implements Typecho_Plugin_Interface
{

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Helper::addRoute("route_catclaw","/catclaw","CatClaw_Action",'action');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        Helper::removeRoute("route_catclaw");
    }
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
       if(Helper::options()->rewrite==0){$index=Helper::options()->rootUrl.'/index.php/';}else{$index=Helper::options()->rootUrl.'/';}
        
        
        $set1 = new Typecho_Widget_Helper_Form_Element_Text('url', NULL, NULL, _t('采集站接口URL'), _t('一般采集站会提供m3u8的接口，比如123ku资源网(http://123ku.com/)就是：http://cj.123ku2.com:12315/inc/sea123kum3u8.php'));
        $form->addInput($set1);
        
        $set6 = new Typecho_Widget_Helper_Form_Element_Text('autoup', NULL, NULL, _t('自动更新参数'), _t('autoup插件的自动更新参数，比如123ku资源网(http://123ku.com/)就是123ku，具体见autoup插件设置说明，此项为选填，不填则默认不设置自动更新参数'));
        $form->addInput($set6);
        
  
        $lianzai = new Typecho_Widget_Helper_Form_Element_Radio('tiao',array('1' => _t('跳过'),'2' => _t('不跳过')),'1',_t('采集时跳过完结番剧'), _t('采集时遇到同名文章，默认会只更新连载状态的视频列表，选择不跳过则不管视频状态是什么都将进行更新操作'));
        $form->addInput($lianzai);  
  
        
        $set2 = new Typecho_Widget_Helper_Form_Element_Text('pass', NULL, NULL, _t('访问密码'), _t('访问密码'));
        $form->addInput($set2);
        
        $set = new Typecho_Widget_Helper_Form_Element_Text('username', NULL, NULL, _t('用户名'), _t('用来发布文章的用户名'));
        $form->addInput($set); 
        $set0 = new Typecho_Widget_Helper_Form_Element_Text('password', NULL, NULL, _t('用户密码'), _t('上方用户名对应的用户密码'));
        $form->addInput($set0);
        
        
        
        

$f='动作片：
爱情片：
喜剧片：
科幻片：
恐怖片：
剧情片：
战争片：
纪录片：
微电影：
伦理片：
动漫电影：';

$t='国产剧：
香港剧：
台湾剧：
韩国剧：
欧美剧：
日本剧：
泰国剧：
其他剧：';

$a='中国动漫：
港台动漫：
日本动漫：
韩国动漫：
欧美动漫：';

$z='内地综艺：
港台综艺：
日韩综艺：
欧美综艺：';


$set3 = new Typecho_Widget_Helper_Form_Element_Textarea('film', NULL,$f, _t('电影分类绑定'), _t('请在冒号后面填写对应的分类mid，不填或者填0采集时则越过该分类，如果资源站电影分类名字与上边设置的不相符，可以回车手动添加比如：艾薇片：分类mid'));
$form->addInput($set3);

$set4 = new Typecho_Widget_Helper_Form_Element_Textarea('tv', NULL,$t, _t('电视剧分类绑定'), _t('请在冒号后面填写对应的分类mid，不填或者填0采集时则越过该分类，如果资源站电视剧分类名字与上边设置的不相符，可以回车手动添加比如：日本剧：分类mid'));
$form->addInput($set4);

$set6 = new Typecho_Widget_Helper_Form_Element_Textarea('zy', NULL,$z, _t('综艺分类绑定'), _t('请在冒号后面填写对应的分类mid，不填或者填0采集时则越过该分类，如果资源站综艺分类名字与上边设置的不相符，可以回车手动添加比如：大陆综艺：分类mid'));
$form->addInput($set6);



$set5 = new Typecho_Widget_Helper_Form_Element_Textarea('anime', NULL,$a, _t('动漫分类绑定'), _t('请在冒号后面填写对应的分类mid，不填或者填0采集时则越过该分类，如果资源站动漫分类名字与上边设置的不相符，程序会自动处理，当自动处理也无法正确分类时可以回车手动添加比如：动画片：分类mid
<section id="custom-field" class="typecho-post-option">
<label id="custom-field-expand" class="typecho-label">采集插件说明</label>
   <br>插件采集会默认跳过同名已存在的文章，会自动更新同名连载状态的文章！文章标签因为采集站接口未提供所以不会写入标签项<br>
   <br>1.采集站必须使用m3u8接口<br>2.以下是操作地址：<br>
    先手动添加：<br>
    <span style="color: red;font-size: 16px;">'.$index.'catclaw/?pg=1&type=add&day=1&id=资源站分类id&pass=你的密码 (GET)</span><br>
    参数：<br>
    pg = 页数<br>
    type = 操作类型（add和cron，add是手动采集，cron是用于服务器定时任务的）<br>
    day = 采集天数，可输入1,7,max（输入1就是采集最近24小时内更新的资源，7就是一周，max就是采集全部）<br>
    id = 采集站上面的分类ID<br>
    pass = 插件后台设置的密码<br>
    <br>
    下面是监控地址：
    <br>
    <span style="color: red;font-size: 16px;">'.$index.'catclaw/?pg=1&type=cron&day=1&id=资源站分类id&pass=你的密码 (GET)</span>
    <br>监控地址一般填于服务器定时任务，day参数不要填max以免卡死！
    <p></p>
    </section>'));
$form->addInput($set5);

    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
   
}
