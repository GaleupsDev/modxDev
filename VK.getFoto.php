/* 
/
/ Статья на Modx.pro
/ https://modx.pro/solutions/8335-photos-vkontakte-in-modx-revo/
/
*/

<?
$oid = $modx->getOption('oid',$scriptProperties,'0');                   //группа или учетка
$aid = $modx->getOption('aid',$scriptProperties,'0');                   //Альбом
$rev = $modx->getOption('rev',$scriptProperties,'1');                   //1 новые сверху
$extended = $modx->getOption('extended',$scriptProperties,'0');         //расширенные поля
$feed_type = $modx->getOption('feed_type',$scriptProperties,'photo');   //photo, photo_tag
$photo_sizes = $modx->getOption('photo_sizes',$scriptProperties,'0');   //1 - позволяет получать все размеры фотографий.
$limit=$modx->getOption('limit',$scriptProperties,'10');                //количество загружаемых фото
$class = $modx->getOption('class',$scriptProperties,'');
$tpl = $modx->getOption('tpl',$scriptProperties,'@INLINE <li>[[+src_big]]</li>');
$cacheOptions = array(
    xPDO::OPT_CACHE_KEY => 'myCache',
    xPDO::OPT_CACHE_HANDLER => 'cache.xPDOAPCCache'
);
$json=$modx->cacheManager->get('getvkphoto'.$aid, $cacheOptions);
if (!isset($json))
{
$url = 'https://api.vk.com/method/photos.get?oid='.$oid.'&aid='.$aid.'&rev='.$rev.'&extended='.$extended.'&feed_type='.$feed_type.'&limit='.$limit.'&photo_sizes='.$photo_sizes;
$json = file_get_contents($url);
$modx->cacheManager->set('getvkphoto'.$aid, $json, 3600, $cacheOptions);
}
$data = json_decode($json, true);
$response = $data['response'];
$output = '';
$pdo = $modx->getService('pdoTools');
foreach ($response as $res) {
    $res['class'] = $class;
    $output .= $pdo->getChunk($tpl, $res);
}
return $output;


//Вызов сниппета:

[[getVKphoto? 
  &oid=`-20629724` 
  &aid=`173443310` 
  &rev=`1` 
  &extended=`0` 
  &feed_type=`photo` 
  &photo_sizes=`0`
  &limit=`15`
  &tpl=`tpl_vkPhoto`
]]
