-- Update for existing installs (run once): coming-soon categories, tracksuits, polo, payment details
ALTER TABLE categories ADD COLUMN coming_soon TINYINT(1) NOT NULL DEFAULT 0 AFTER status;
UPDATE categories SET coming_soon = 1 WHERE parent_id = 0 AND slug IN ('women','kids','footwear','accessories');

-- Winter Edit -> Tracksuits
UPDATE categories SET name='Tracksuits', slug='tracksuits', description='Comfort-first sets, jackets and track pants.' WHERE slug='winter-edit';
UPDATE categories SET name='Tracksuit Sets', slug='tracksuit-sets' WHERE slug='coats';
UPDATE categories SET name='Track Jackets', slug='track-jackets' WHERE slug='sweaters';
UPDATE categories SET name='Track Pants', slug='track-pants' WHERE slug='scarves-and-shawls';
UPDATE products SET name='Zip Tracksuit Set', short_description='Soft fleece zip set.', price=8990, sale_price=7490, stock=42, sizes='S,M,L,XL', category_id=(SELECT id FROM categories WHERE slug='tracksuit-sets') WHERE slug='wool-blend-overcoat';
UPDATE products SET name='Fleece Track Jacket', price=5490, sale_price=NULL, category_id=(SELECT id FROM categories WHERE slug='track-jackets') WHERE slug='merino-crew-sweater';
UPDATE products SET name='Tapered Track Pants', price=3490, sale_price=2790, sizes='30,32,34,36', category_id=(SELECT id FROM categories WHERE slug='track-pants') WHERE slug='cashmere-blend-scarf';

-- point renamed products to their new slug + artwork
UPDATE products SET slug='zip-tracksuit-set', image='products/zip-tracksuit-set.svg' WHERE slug='wool-blend-overcoat';
UPDATE products SET slug='fleece-track-jacket', image='products/fleece-track-jacket.svg' WHERE slug='merino-crew-sweater';
UPDATE products SET slug='tapered-track-pants', image='products/tapered-track-pants.svg' WHERE slug='cashmere-blend-scarf';
UPDATE product_images pi JOIN products p ON p.id=pi.product_id SET pi.image=REPLACE(REPLACE(REPLACE(pi.image,'wool-blend-overcoat','zip-tracksuit-set'),'merino-crew-sweater','fleece-track-jacket'),'cashmere-blend-scarf','tapered-track-pants');
UPDATE categories SET image='categories/cat-tracksuits.svg' WHERE slug='tracksuits';

-- Men: separate Polo Shirts submenu
INSERT INTO categories (parent_id,name,slug,sort_order,status,coming_soon,created_at)
  SELECT id,'Polo Shirts','polo-shirts',2,1,0,NOW() FROM categories WHERE slug='men';
UPDATE products SET category_id=(SELECT id FROM categories WHERE slug='polo-shirts') WHERE slug='classic-piqu-polo';

-- Payment details (editable in Admin > Settings)
INSERT IGNORE INTO settings (skey,svalue) VALUES
 ('easypaisa_details','Easypaisa: 0300 1234567\nAccount title: DRESSY Fashion House'),
 ('jazzcash_details','JazzCash: 0300 7654321\nAccount title: DRESSY Fashion House'),
 ('logo','');
