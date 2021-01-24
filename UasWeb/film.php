<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "uas.web";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if(@$_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE film set
											 	judul_film = '$_POST[tjudul]',
												kategori = '$_POST[tkategori]',
											 	tahun_rilis = '$_POST[trilis]'
											 WHERE id_film = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='film.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='film.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO film (judul_film, kategori, tahun_rilis)
										  VALUES ( 
										  		 '$_POST[tjudul]', 
										  		 '$_POST[tkategori]', 
										  		 '$_POST[trilis]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='film.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='film.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if(@$_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM film WHERE id_film = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
			
				$vjudul = $data['judul_film'];
				$vkategori = $data['kategori'];
				$vrilis = $data['tahun_rilis'];
			}
		}
		else if (@$_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM film WHERE id_film = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='film.php';
				     </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<title>Data Bioskop Maccel</title>
</head>
<body style="background-color: #c8d6e5">
<div class="container">

	<h1 class="text-center">DATABASE FILM</h1>
	<h2 class="text-center">Bioskop Maccel</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Film
	  </div>
	  <div class="card-body">
	    <form method="post" action="">

	    	<div class="form-group">
	    		<label>Judul film</label>
	    		<input type="text" name="tjudul" value="<?=@$vjudul?>" class="form-control" placeholder="Input Judul Film anda disini!" required>
	    	</div>

	    	<div class="form-group">
	    		<label>Kategori</label>
	    		<select class="form-control" name="tkategori">
	    			<option value="<?=@$vkategori?>"><?=@$vkategori?></option>
	    			<option value="Horror">Horror</option>
	    			<option value="Comedy">Comedy</option>
	    			<option value="Action">Action</option>
	    			<option value="Romance">Romance</option>
	    		</select>
	    	</div>

	    	<div class="form-group">
	    		<label>Tahun Rilis</label>
	    		<textarea class="form-control" name="trilis"  placeholder="Input Tahun Rilis disini!"><?=@$vrilis?></textarea>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Film
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Judul Film</th>
	    		<th>Kategori</th>
	    		<th>Tahun Rilis</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from film order by id_film desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['judul_film']?></td>
	    		<td><?=$data['kategori']?></td>
	    		<td><?=$data['tahun_rilis']?></td>
	    		<td>
	    			<a href="film.php?hal=edit&id=<?=$data['id_film']?>" class="btn btn-warning"> Edit </a>
	    			<a href="film.php?hal=hapus&id=<?=$data['id_film']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->
	<a href="index.php" class="btn btn-outline-primary">Data Karyawan</a>
		<a href="film.php" class="btn btn-outline-primary">Data Film</a>
			<a href="pelanggan.php" class="btn btn-outline-primary">Data Pelanggan</a>
</div>
 <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>