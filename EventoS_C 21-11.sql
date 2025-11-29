USE EventosC;

-- | TABLAS REGULARES | --
CREATE TABLE Roles(
	id int primary key auto_increment,
	nombre varchar(50) not null unique
);

CREATE TABLE Servicios (
    id int primary key auto_increment,
    nombre varchar(100) not null unique
);

CREATE TABLE Proveedores(
	id int primary key auto_increment,
    nombre_empresa varchar(150) not null unique,
    nombre_responsable varchar(150) not null unique,
    telefono varchar(9) not null unique,
    email varchar(150) not null unique,
    direccion varchar(150) not null,
    estado ENUM ('Disponible', 'No disponible', 'Ocupado') DEFAULT ('Disponible'),
    id_servicio int,
    
    foreign key (id_servicio) references Servicios(id)
);

CREATE TABLE Cliente(
	id int primary key auto_increment,
    nombre varchar(100) not null,
    apellidos varchar(100) not null,
    telefono varchar(9) not null,
    correo varchar(150) not null,
    fecha_inscripcion date default(now()),
    dni varchar(8) not null unique,
    estado varchar(20) not null
);

CREATE TABLE Evento(
	id int primary key auto_increment,
    nombre varchar(100) not null unique,
    estado ENUM ('Disponible', 'No Disponible') DEFAULT ('Disponible')
);

CREATE TABLE Ubicacion(
	id int primary key auto_increment,
    nombre varchar(100) not null unique
);

CREATE TABLE Tipo_Recurso(
	id int primary key auto_increment,
    nombre varchar(100) not null unique
);

CREATE TABLE Tipo_Pago(
	id int primary key auto_increment,
    nombre varchar(100) not null unique
);

CREATE TABLE Adelanto(
	id int primary key auto_increment,
    valor decimal(5,2)
);

-- | TABLAS CON RELACIONES | --

CREATE TABLE Usuario(
	id int primary key auto_increment,
    nombre varchar(100) not null unique,
    correo varchar(150) not null unique,
    fecha_registro datetime default(now()),
    estado ENUM('Activo', 'Inactivo') default('Activo'),
    id_rol int,
    
    foreign key (id_rol) references Roles (id)
);

CREATE TABLE Pagos(
	id int primary key auto_increment,
    numero_tarjeta varchar(16) null unique,
    fecha_vencimiento date null,
    cvv varchar(4) null,
    voucer varchar(50) null,
    id_tipo_pago int,
    id_adelanto int,
    
    foreign key (id_tipo_pago) references Tipo_Pago(id),
    foreign key (id_adelanto) references Adelanto(id)
);

CREATE TABLE Recursos(
	id int primary key auto_increment,
    nombre_recurso varchar(100) not null,
    cantidad int default(0),
    ubicacion varchar(50),
    estado ENUM('Disponible', 'No disponible', 'En uso', 'Mantenimiento') default('Disponible'),
    prox_mantenimiento date,
    id_tipo int,
    
    foreign key (id_tipo) references Tipo_Recurso(id)
);

CREATE TABLE Mantenimiento(
	id int primary key auto_increment,
    fecha date,
    costo decimal(6,2),
    descripcion varchar(250),
    prox_mantenimiento date,
    id_recursos int,
    
    foreign key (id_recursos) references Recursos(id)
);

CREATE TABLE Reservas(
	id int primary key auto_increment,
    fecha date,
    numero_asistentes int,
    total decimal(8,2),
    estado ENUM('Cancelada', 'Con Adelanto', 'Por Pagar') default('Por Pagar'),
    id_cliente int,
    id_pagos int,
	id_evento int,
    id_ubicacion int,
    
    foreign key (id_cliente) references Cliente(id),
    foreign key (id_pagos) references Pagos(id),
    foreign key (id_evento) references Evento(id),
    foreign key (id_ubicacion) references Ubicacion(id)
);

-- | TABLAS COMPUESTAS | --

CREATE TABLE Usuario_Reservas(
	id_usuario int,
    id_reservas int,
    
    primary key (id_usuario, id_reservas),
    foreign key (id_usuario) references Usuario(id),
    foreign key (id_reservas) references Reservas(id)
);

CREATE TABLE Reservas_Proveedor(
    id_reservas int,
    id_proveedores int,
    
    primary key (id_proveedores, id_reservas),
    foreign key (id_proveedores) references Proveedores(id),
    foreign key (id_reservas) references Reservas(id)
);

CREATE TABLE Reservas_Recursos(
    id_reservas int,
    id_recursos int,
    
    primary key (id_recursos, id_reservas),
    foreign key (id_recursos) references Recursos(id),
    foreign key (id_reservas) references Reservas(id)
);





SELECT * FROM cliente;


INSERT INTO Cliente (id, nombre, apellidos, telefono, correo, dni, estado) 
VALUES (1, 'Juan Alberto', 'Perez Ñuñoa', '999222333', 'juannino@gmail.com', '77721399', 'Activo');