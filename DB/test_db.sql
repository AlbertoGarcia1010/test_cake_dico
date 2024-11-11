create database test_cake_dico_db;

use test_cake_dico_db;


CREATE TABLE cliente (
id int,
nombre varchar(45),
apellido varchar(45),
direccion varchar(100),
email varchar(45),
usuario varchar(45),
fecha_nacimiento Date,
created_at Timestamp,
updated_at Datetime,
PRIMARY KEY (id)
);

CREATE UNIQUE INDEX email_UNIQUE
ON cliente (email);

CREATE UNIQUE INDEX usuario_UNIQUE
ON cliente (usuario);

CREATE TABLE empleado (
id int,
nombre varchar(45),
apellido varchar(45),
telefono varchar(20),
created_at Timestamp,
updated_at Datetime,
PRIMARY KEY (id)
);

CREATE TABLE venta (
id int,
id_empleado int,
id_cliente int,
total DECIMAL(9,2),
estatus TINYINT,
created_at Timestamp,
updated_at Datetime,
PRIMARY KEY (id),
FOREIGN KEY (id_empleado) REFERENCES empleado (id),
FOREIGN KEY (id_cliente) REFERENCES cliente (id)
);

CREATE INDEX empleado_idx
ON venta (id_empleado);

CREATE INDEX cliente_idx
ON venta (id_cliente);

CREATE TABLE producto (
upc varchar(45),
descripcion varchar(100),
costo DECIMAL(8,2),
precio DECIMAL(8,2),
existencia int,
created_at Timestamp,
updated_at Datetime,
PRIMARY KEY (upc)
);

CREATE UNIQUE INDEX upc_UNIQUE
ON producto (upc);

CREATE TABLE venta_detalle (
id int,
id_venta int,
id_producto varchar(45),
precio DECIMAL(8,2),
cantidad int,
utilidad DECIMAL(8,2),
created_at Timestamp,
updated_at Datetime,
PRIMARY KEY (id),
FOREIGN KEY (id_venta) REFERENCES venta (id),
FOREIGN KEY (id_producto) REFERENCES producto (upc)
);

CREATE INDEX venta_idx
ON venta_detalle (id_venta);

CREATE INDEX producto_idx
ON venta_detalle (id_producto);

ALTER TABLE venta DROP FOREIGN KEY venta_ibfk_2;

ALTER TABLE cliente MODIFY COLUMN id int(11) auto_increment NOT NULL;

ALTER TABLE venta 
ADD CONSTRAINT venta_ibfk_2 FOREIGN KEY (id_cliente) REFERENCES cliente(id);

ALTER TABLE venta DROP FOREIGN KEY venta_ibfk_1;

ALTER TABLE empleado MODIFY COLUMN id int(11) auto_increment NOT NULL;

ALTER TABLE venta 
ADD CONSTRAINT venta_ibfk_1 FOREIGN KEY (id_empleado) REFERENCES empleado(id);


ALTER TABLE venta_detalle DROP FOREIGN KEY venta_detalle_ibfk_1;
ALTER TABLE venta MODIFY COLUMN id int(11) auto_increment NOT NULL;
ALTER TABLE venta_detalle 
ADD CONSTRAINT venta_detalle_ibfk_1 FOREIGN KEY (id_venta) REFERENCES venta(id);