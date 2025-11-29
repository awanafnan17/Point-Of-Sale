INSERT INTO ospos.ospos_items (name, category, description, cost_price, unit_price, item_number, reorder_level, receiving_quantity, allow_alt_description, is_serialized, deleted, stock_type, item_type, qty_per_pack) VALUES ('Shan Masala', 'Grocery', 'Spice mix', 50, 60, '123456789', 10, 1, 0, 0, 0, 0, 0, 1);
SET @item_id = LAST_INSERT_ID();
INSERT INTO ospos.ospos_item_quantities (item_id, location_id, quantity) VALUES (@item_id, 1, 100);
