create table proveedor(
	id_proveedor int auto_increment,
	proveedor varchar (50),
	constraint proveedorPK primary key (id_proveedor)
)
create table marca (
	id_marca int auto_increment,
	marca varchar(50),
	id_proveedor int,
	constraint marcaPK primary key (id_marca),
	constraint marcaFK foreign key (id_proveedor) references proveedor(id_proveedor)
)
create table producto (
	id int auto_increment,
	nombre varchar(50),
	foto varchar(50),
	precio float,
	id_marca int,
	constraint productoPK primary key (id),
	constraint productoFK foreign key (id_marca) references marca(id_marca)
)

create table categoria (
	id_categoria int auto_increment,
	nombre varchar (50),
	imagen blob,
	constraint categoriaPK primary key (id_categoria)
)
create table producto_categoria (
	id_categoria int,
	id int,
	constraint producto_categoriaFK1 foreign key (id_categoria) references categoria(id_categoria),
	constraint producto_categoriaFK2 foreign key (id) references producto(id)
)

create table estado (
	id_estado int auto_increment,
	estado varchar (50),
	constraint estadoPK primary key (id_estado) 
)
create table municipio 





