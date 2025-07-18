<?php 

class statModel extends Model
{
  public static function by_month($months = 1, $table, $xkey)
  {
    // Current Month
    $stmt = "SELECT COUNT(t.$xkey) AS ykeys, DATE_FORMAT(merge_date, '%M %Y') AS xkey, YEAR(m.merge_date) AS year
    FROM (";

    if($months == 1){
      $stmt .= " SELECT CURRENT_DATE AS merge_date ";
    } else {
      for ($i=0; $i < intval($months); $i++) { 
        $stmt .= ($i == 0 ? "" : " UNION ")." SELECT CURRENT_DATE ".($i == 0 ? "" : "- INTERVAL ".$i." MONTH")." AS merge_date";
      }
    }

    $stmt .= ") AS m LEFT JOIN $table t ON MONTH(m.merge_date) = MONTH(t.$xkey) AND YEAR(m.merge_date) = YEAR(t.$xkey) 
    GROUP BY m.merge_date 
    ORDER BY DATE_FORMAT(merge_date , '%Y %m') ASC;";

    return ($rows = parent::query($stmt)) ? $rows : false;
  }

  // Ingresos mensuales al mes
  public static function sum_by_month($months = 1, $table, $xkey, $ykey)
  {
    // Current Month
    $stmt = "SELECT ROUND(COALESCE(SUM(t.$ykey), 0), 2) AS ykeys, DATE_FORMAT(merge_date, '%M %Y') AS xkey, YEAR(m.merge_date) AS year
    FROM (";

    if($months == 1){
      $stmt .= " SELECT CURRENT_DATE AS merge_date ";
    } else {
      for ($i=0; $i < intval($months); $i++) { 
        $stmt .= ($i == 0 ? "" : " UNION ")." SELECT CURRENT_DATE ".($i == 0 ? "" : "- INTERVAL ".$i." MONTH")." AS merge_date";
      }
    }

    $stmt .= ") AS m LEFT JOIN $table t ON MONTH(m.merge_date) = MONTH(t.$xkey) AND YEAR(m.merge_date) = YEAR(t.$xkey) 
    GROUP BY m.merge_date 
    ORDER BY DATE_FORMAT(merge_date , '%Y %m') ASC;";

    return ($rows = parent::query($stmt)) ? $rows : false;
  }
}
