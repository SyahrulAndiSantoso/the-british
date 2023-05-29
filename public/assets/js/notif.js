const aksi = $('.flash-data').data('aksi');
const halaman = $('.flash-data').data('halaman');
const title = $('.flash-data').data('title');

if((title=="Gagal")&&(aksi=="Login"||aksi=="Menambahkan"||aksi=="Checkout")){
iziToast.error({
title: title,
message: aksi+' '+halaman,
position: 'topRight'
});
}else
if((title=="Berhasil")&&(aksi=="Menambahkan"||aksi=="Menghapus"||aksi=="Mengupdate")){
iziToast.success({
title: title,
message: aksi+' '+halaman,
position: 'topRight'
});
}else if(title == "Gagal Menghapus"){
iziToast.error({
title: title,
message: halaman+' Tertaut Pada Tabel Lain',
position: 'topRight'
});
}else if((title=="Gagal")&&(aksi!="Login"||aksi!="Menambahkan"||aksi!="Checkout")){
iziToast.error({
title: title,
message: aksi,
position: 'topRight'
});
}
