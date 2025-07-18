<?php 

// QR Generator
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

// Namespace Dompdf
use Dompdf\Dompdf;

// Snapy
//use Knp\Snappy\Pdf;

// Faker
use Faker\ORM\Propel\Populator;
use Faker\Factory;
use Faker\Provider\Base;
use Faker\Provider\Internet;
use Faker\Provider\UserAgent;
use Faker\Provider\Payment;
use Faker\Provider\Color;
use Faker\Provider\File;
use Faker\Provider\Image;
use Faker\Provider\Miscellaneous;
use Faker\Provider\HtmlLorem;
use Faker\Provider\DateTime;
use Faker\Provider\en_US\Company;
use Faker\Provider\en_US\PhoneNumber;

use Spatie\DbDumper\Databases\MySql;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class testsController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
	}
}