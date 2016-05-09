<? if (empty($files)) header("HTTP/1.0 404 Not Found"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<link rel="stylesheet" href="//bootswatch.com/cosmo/bootstrap.min.css"/>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Index of <?= $config['bucket-name'].$dir ?></title>
</head>
<body>
<div class="navbar navbar-default">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><?= $config['page-header'] ?></a>
    </div>
</div>

  <div id="contents" class="container">
      <ul class="breadcrumb">
         <li><a href="<?= $config['base-path'] ?>/"><?= $config['bucket-name'] ?>/</a></li>
        <? foreach (S3Browser::getBreadcrumb($dir) as $key => $name): ?>
                <? if ($key != '/'): ?>
                <li><a href="<?= $config['base-path'] ?>/<?= $name ?>"><?= $key ?>/</a></li>
                <? endif; ?>
                <? endforeach ?>
      </ul>
    <? if (empty($files)): ?>
      <div class="alert alert-dismissible alert-warning">
        <h4>No files found.</h4>
      </div>
    <? else: ?>
      <table class="table table-striped table-hover ">
          <thead>
          <tr>
              <th>File</th>
              <th>Size</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
           <? if (S3Browser::getParent($dir) !== null): ?>
                <tr>
                <td>
                <a href="<?= $config['base-path'] ?>/<?= S3Browser::getParent($dir) ?>">
                                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                    <span>..</span>
                                  </a>
                </td>
                <td></td>
                  <td></td>
                </tr>
              <? endif; ?>


               <? foreach ($files as $key => $info): ?>
                    <? $asTorrent = (!is_null($config['torrent-threshold']) && $info['size'] > $config['torrent-threshold']); ?>
                    <tr>

                      <td>
                      <? if (is_array($info['files'])): ?>
                        <a href="<?= $config['base-path'] ?>/<?= $info['path'] ?>">
                          <i class="fa fa-folder-open" aria-hidden="true"></i>
                          <span><?= $key ?></span>
                        </a>
                      <? else: ?>
                      <i class="fa fa-file" aria-hidden="true"></i>
                         <a href="<?= $config['bucket-url-prefix'] ?>/<?= $info['path'] ?><? if ($asTorrent): ?>?torrent<? endif; ?>" <? if (isset($config['google-analytics-id'])): ?><? endif; ?>
                        <span><?= $key ?></span>
                      </a>
                      <td>
                      <span class="size"><?= $info['hsize'] ?></span>
                      </td>
                      <td style="text-align:center;">
                      <a href="<?= $config['bucket-url-prefix'] ?>/<?= $info['path'] ?><? if ($asTorrent): ?>?torrent<? endif; ?>">
                            <i class="fa fa-download" aria-hidden="true" style="font-size: 2rem"></i>

                      </a>
                      </td>
                      <? endif; ?>
                     </td>
                  </tr>
                  <? endforeach; ?>
          </tbody>
          </table>
       <? endif; ?>




  </div>
  
<div id="footer">
    <a href="https://cuescience.de"><img src="https://cuescience.de/static/website/img/logo_cue.png" alt="cuescience logo" style="width: 185px; margin: 1rem auto 2.4rem;display: block;"></a>
</div>

  <? if (isset($config['google-analytics-id'])): ?>
  <script type="text/javascript">
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
  var pageTracker = _gat._getTracker("<?= $config['google-analytics-id'] ?>");
  pageTracker._initData();
  pageTracker._trackPageview();
  </script>
  <? endif; ?>
</body>
</html>
