create database db_pariwisata;

use db_pariwisata;

create table tb_user(
    id_user int auto_increment primary key,
    username varchar(50) not null,
    password varchar(50) not null,
    level enum('admin', 'pengunjung', 'sponsor') not null
);

create table tb_pengunjung(
    id_pengunjung int auto_increment primary key,
    nama varchar(50) not null,
    alamat varchar(100) not null,
    no_telp varchar(15) not null,
    email varchar(50) not null,
    username varchar(50) not null,
    password varchar(50) not null
);

create table tb_sponsor(
    id_sponsor int auto_increment primary key,
    nama varchar(50) not null,
    gambar text not null,
    alamat varchar(100) not null,
    no_telp varchar(15) not null,
    email varchar(50) not null,
    username varchar(50) not null,
    password varchar(50) not null
);

create table tempat_wisata(
    id_tempat int auto_increment primary key,
    nama_tempat varchar(50) not null,
    alamat varchar(100) not null,
    deskripsi text not null,
    gambar varchar(100) not null,
    harga_tiket decimal(10,2) not null,
    jam_buka time not null,
    jam_tutup time not null,
    fasilitas text not null
);

create table tb_pemesanan(
    id_pemesanan int auto_increment primary key,
    id_pengunjung int not null,
    id_tempat int not null,
    tanggal date not null,
    jumlah_tiket int not null,
    total_harga decimal(10,2) not null,
    foreign key (id_pengunjung) references tb_pengunjung(id_pengunjung),
    foreign key (id_tempat) references tempat_wisata(id_tempat)
);

create table tb_transaksi(
    id_transaksi int auto_increment primary key,
    id_pemesanan int not null,
    tanggal_transaksi date not null,
    total_harga decimal(10,2) not null,
    status enum('lunas', 'belum lunas') not null,
    foreign key (id_pemesanan) references tb_pemesanan(id_pemesanan)
);

create table tb_berita(
    id_berita int auto_increment primary key,
    judul varchar(255) not null,
    isi text not null,
    tanggal datetime not null default current_timestamp
);

create table tb_gambar(
    id_gambar int auto_increment primary key,
    id_berita int not null,
    gambar varchar(100) not null,
    foreign key (id_berita) references tb_berita(id_berita)
);