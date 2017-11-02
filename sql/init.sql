USE f36im;

START TRANSACTION;
CREATE TABLE products (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    category CHAR(4) NOT NULL,
    gender CHAR(1) NOT NULL,
    description VARCHAR(500)  NOT NULL,
    price DECIMAL(7,2) UNSIGNED NOT NULL,
    discount FLOAT(4,2) UNSIGNED DEFAULT 0,
	UNIQUE KEY (name)
);

CREATE TABLE inventory (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    productsID INT UNSIGNED NOT NULL,
    color VARCHAR(20) NOT NULL,
    size VARCHAR(3) NOT NULL,
    stock INT UNSIGNED NOT NULL,
    UNIQUE KEY(productsID, color, size),
    FOREIGN KEY inventory(productsID) REFERENCES products(id)
);

CREATE TABLE customers (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	fullName VARCHAR(100) NOT NULL,
	gender CHAR(1),
	phone VARCHAR(15) NOT NULL,
	address VARCHAR(150) NOT NULL,
	country VARCHAR(20) NOT NULL,
	birthday DATE
);

CREATE TABLE accounts (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(50) NOT NULL,
	password CHAR(41) NOT NULL,
	role CHAR(4) NOT NULL,
	customersID INT UNSIGNED NOT NULL,
	UNIQUE KEY (email),
	FOREIGN KEY accounts(customersID) REFERENCES customers(id)
);

CREATE TABLE orders (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ordersDate DATETIME NOT NULL ,
	customersID INT UNSIGNED NOT NULL, 
	shipping CHAR(1) NOT NULL,
    FOREIGN KEY orders(customersID) REFERENCES customers(id)
);

CREATE TABLE orders_inventory (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	ordersID INT UNSIGNED NOT NULL,
	inventoryID INT UNSIGNED NOT NULL,
	quantity INT UNSIGNED NOT NULL,
	pricePerItem DECIMAL(7,2) UNSIGNED NOT NULL,
	UNIQUE KEY(ordersID, inventoryID),
    FOREIGN KEY orders_inventory(ordersID) REFERENCES orders(id),
	FOREIGN KEY orders_inventory(inventoryID) REFERENCES inventory(id)
);

INSERT INTO products (name, category, gender, description, price, discount) VALUES ("J.W. Anderson Striped Short Sleeve", "TSHT", "M",
                              "A t-shirt with vibrant stripes featuring JW Anderson's distinctive colors.\n
                              - From our collaboration collection with English fashion designer JW Anderson.\n
                              - Striped pattern showcasing beautiful colors.\n
                              - Adds a bold, stylish touch to any outfit.",
 12.90, 0);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (1, "Blue", "M", 3);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (1, "Gray", "M", 2);

 INSERT INTO products (name, category, gender, description, price, discount) VALUES ("Supima Cotton V Neck Short Sleeve", "TSHT", "M",
                                "Made with rare, 100% Supima® cotton, this V-neck t-shirt looks sharp all on its own.\n
                               - A quality t-shirt made with 100% rare Supima® cotton.\n
                               - This wardrobe classic deserved the best fabric, design and construction we could give it.\n
                               - Carefully designed for the perfect shape, it looks great on its own.\n
                               - The shallow V-neck makes it easy to wear layered or on its own.\n
                               - Featured in a lineup of colors that showcase the quality of the fabric.",
  14.90, 0);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (2, "Black", "M", 6);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (2, "Blue", "M", 2);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (2, "Brown", "M", 5);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (2, "Gray", "M", 7);
 INSERT INTO inventory (productsID, color, size, stock) VALUES (2, "Pink", "M", 4);
 COMMIT;