<?php
/**
 * Real photos ko products/banners/categories se jorne ka tool.
 * Usage:  php tools/apply_real_images.php
 *
 * Photos is tarah rakhein (jpg/jpeg/png/webp):
 *   uploads/products/<product-slug>.jpg        (main photo)
 *   uploads/products/<product-slug>-2.jpg      (gallery, optional)
 *   uploads/products/<product-slug>-3.jpg      (gallery, optional)
 *   uploads/banners/hero-1.jpg ... hero-4.jpg, promo-1.jpg ... promo-3.jpg
 *   uploads/categories/<category-slug>.jpg
 * Jo file mile uski DB entry update ho jati hai, baqi purani rehti hai.
 */
define('BASEPATH', 1);
$root = dirname(__DIR__);
$db = array();
include $root . '/application/config/database.php';
$c = $db['default'];
$pdo = new PDO("mysql:host={$c['hostname']};dbname={$c['database']};charset=utf8mb4", $c['username'], $c['password']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$exts = array('jpg', 'jpeg', 'png', 'webp');
$find = function ($folder, $base) use ($root, $exts) {
    foreach ($exts as $e) {
        if (is_file("$root/uploads/$folder/$base.$e")) return "$folder/$base.$e";
    }
    return null;
};
$n = 0;
foreach ($pdo->query('SELECT id, slug FROM products') as $p) {
    $main = $find('products', $p['slug']);
    if (!$main) continue;
    $pdo->prepare('UPDATE products SET image=? WHERE id=?')->execute(array($main, $p['id']));
    $pdo->prepare('DELETE FROM product_images WHERE product_id=?')->execute(array($p['id']));
    $ins = $pdo->prepare('INSERT INTO product_images (product_id,image,sort_order) VALUES (?,?,?)');
    $ins->execute(array($p['id'], $main, 0));
    foreach (array(2, 3, 4, 5) as $i) {
        if ($g = $find('products', $p['slug'] . '-' . $i)) $ins->execute(array($p['id'], $g, $i - 1));
    }
    $n++;
}
echo "Products updated: $n\n";
$b = 0;
foreach ($pdo->query('SELECT id FROM banners ORDER BY sort_order, id') as $i => $row) {
    $f = $find('banners', 'hero-' . ($i + 1)) ?: $find('banners', 'promo-' . ($i - 3));
    if ($f) { $pdo->prepare('UPDATE banners SET image=? WHERE id=?')->execute(array($f, $row['id'])); $b++; }
}
echo "Banners updated: $b\n";
$k = 0;
foreach ($pdo->query('SELECT id, slug FROM categories') as $r) {
    $f = $find('categories', $r['slug']);
    if ($f) { $pdo->prepare('UPDATE categories SET image=? WHERE id=?')->execute(array($f, $r['id'])); $k++; }
}
echo "Categories updated: $k\n";
