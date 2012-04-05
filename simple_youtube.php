<?php
// A simple downloader for YouTube files
// Created for Mike King for a kiosk he was working on
// Uses `youtube-dl` to download files, then lists the contents of the directory 
//
// Written by Daniel Lewis, 2012


// Load data

  $fmts = array( 37 => 'H264 video in MP4 container at 1080p',
                 22 => 'H264 video in MP4 container at 720p',
                 18 => 'H264 video in MP4 container at 480p',
                 35 => 'H264 video in FLV container at 480p',
                 34 => 'H264 video in FLV container at 360p',
                 45 => 'WebM video at 720p',
                 43 => 'WebM video at 480p',
                 17 => '3GP video' );

  $urls = array_key_exists('url', $_GET) ?
      explode(' ', $_GET['url']) : array();

  $files = scandir('.');


// generate HTML
?>
<html>
  <head>
    <style type="text/css">
      h1 { text-align:center; }
      p { width:100%; text-align:center; }
      textarea { width:100%; height:300px; }
    </style>

    <script type='text/javascript'>
      document.onload = function() {
        document.getElementById('downloadlink').onclick = function(e) {
          window.location = window.location.origin + window.location.pathname + '?url=' + document.getElementById('url').value + '&fmt=' + document.getElementById('fmt').value
          return false
        }
      }
    </script>
  </head>

  <body>
    <h1>youtube-dl downloader</h1>
    <textarea name='url' id='url'></textarea>
    <label for='fmt'>Video Format</label>

    <select name='fmt' id='fmt'>
      <?php
        foreach($fmts as $fmtid => $fmtdesc) {
          print "<option value=$fmtid>$fmtdesc</option>";
        }
      ?>
    </select>
    <p>
      <a href='#' id='downloadlink'>Download All Of These</a> || <a href='/../'>back to index</a>
    </p>
    
   
    <h2>download process output</h2>
    <pre>
      <?php
        foreach($urls as $url) {
          print "bash -c \"/usr/bin/python /usr/bin/youtube-dl -t $url -f $fmt\"\n";
          system("bash -c \"/usr/bin/python /usr/bin/youtube-dl -t $url -f $fmt 2>&1\"");
        }
      ?>
    </pre>
    
    <h2>downloaded files</h2>
    <ul>
      <?php 
        foreach($files as $file) {
          if ($file != 'download_youtube.php' && $file != '.download_youtube.php.swp' && $file != '.' && $file != '..') {
            echo "<li><a href='$file'>$file</a></li>";
          }
        }
      ?>
    </ul>
  </body>
</html>
    
