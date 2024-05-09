<?php
class Search extends Controller
{
	private $data;
	private $username;
	private $unit;
	private $level;

	public function __construct()
	{
		if (!isset($_POST['search']) && !isset($_POST['filter'])) {
			$this->redirect('forbidden');
		}

		$this->username = $_SESSION['user'];
		$this->unit = $this->model('UserModel')->getUnitByUsername($this->username);
		$this->level = $this->model('UserModel')->getLevelByUsername($this->username);

		$this->data = [
			'css' => ['Dashboard/Style.css', 'Dashboard/Peminjaman.css'],
			'js' => ['Dashboard/Main.js'],
			'user' => $this->username,
			'unit' => $this->unit,
			'level' => $this->level
		];
	}

	public function index()
	{
		Search::__construct();
	}

	public function all_peminjaman()
	{
		$search = $_POST['search'];
		$_SESSION['search_all'] = $search;

		$start = 0;
		$limit = (int) $_POST['limit'];
		$totalRows = (int) $this->model('PeminjamanModel')->countSearchAllPeminjaman($search);

		if ($limit == -1) {
			$limit = $totalRows;
		}

		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = ceil($totalRows / $limit);
		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = 1;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchAllPeminjaman($search, $start, $limit);

		$this->helper('Dashboard/allPeminjaman', $this->data);
	}

	public function my_peminjaman()
	{
		$search = $_POST['search'];
		$_SESSION['search_my'] = $search;

		$start = 0;
		$limit = (int) $_POST['limit'];
		$totalRows = (int) $this->model('PeminjamanModel')->countSearchMyPeminjaman($search, $this->unit);

		if ($limit == -1) {
			$limit = $totalRows;
		}

		$this->data['totalRows'] = $totalRows;
		$this->data['totalHalaman'] = ceil($totalRows / $limit);
		$this->data['numStart'] = ($totalRows > 0) ? $start + 1 : 0;
		$this->data['currPage'] = 1;
		$this->data['peminjaman'] = $this->model('PeminjamanModel')->searchMyPeminjaman($search, $start, $limit, $this->unit);

		$this->helper('Dashboard/myPeminjaman', $this->data);
	}
}
