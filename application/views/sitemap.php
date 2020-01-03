<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<url>
<loc><?= base_url(); ?></loc>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>
<url>
<loc><?= base_url('login'); ?></loc>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>
<url>
<loc><?= base_url('join'); ?></loc>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>
<url>
<loc><?= base_url('password_reset'); ?></loc>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>

</urlset>