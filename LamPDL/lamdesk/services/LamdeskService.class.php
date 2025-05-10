<?php
/**
 * @copyright   &copy; 2005-2024 PHPBoost
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      mipel <mipel@phpboost.com>
 * @version     PHPBoost 6.0 - last update: 2024 12 22
 * @since       PHPBoost 6.0 - 2024 12 22
 */
class LamdeskService
{
    private static $db_querier;

    public static function __static()
    {
        self::$db_querier = PersistenceContext::get_querier();
    }

    public static function get_count_clubs_ffam()
    {
        $req = self::$db_querier->select('select
            (select count(*) from phpboost_lamclubs),
            (select count(*) from phpboost_lamclubs where department= 44),
            (select count(*) from phpboost_lamclubs where department= 49),
            (select count(*) from phpboost_lamclubs where department= 53),
            (select count(*) from phpboost_lamclubs where department= 72),
            (select count(*) from phpboost_lamclubs where department= 85);
        ');

        while ($row = $req->fetch())
        {
            foreach ($row as $club)
            {
                $data[] = $club;
            }
            return $data;
        }
        $req->dispose();
    }

    public static function get_clubs_by_dept($dept)
    {
        if ($dept != '00')
        {
            $req = self::$db_querier->select('SELECT lc.name, lc.ffam_nb, lc.website_url 
        FROM phpboost_lamclubs lc
        WHERE lc.department = ' . $dept . '');
        } else
        {
            $req = self::$db_querier->select('SELECT lc.name, lc.ffam_nb, lc.website_url 
        FROM phpboost_lamclubs lc');
        }

        while ($row = $req->fetch())
        {
            $clubs_by_dept[] = $row;
        }
        return $clubs_by_dept;
        $req->dispose();
    }

    public static function get_count_clubs_site()
    {
        $req = self::$db_querier->select('(SELECT
            COUNT(DISTINCT f_votre_club) AS total_clubs,
            COUNT(DISTINCT CASE WHEN f_votre_club LIKE "%- 44 -%" THEN f_votre_club END) AS dept_44,
            COUNT(DISTINCT CASE WHEN f_votre_club LIKE "%- 49 -%" THEN f_votre_club END) AS dept_49,
            COUNT(DISTINCT CASE WHEN f_votre_club LIKE "%- 53 -%" THEN f_votre_club END) AS dept_53,
            COUNT(DISTINCT CASE WHEN f_votre_club LIKE "%- 72 -%" THEN f_votre_club END) AS dept_72,
            COUNT(DISTINCT CASE WHEN f_votre_club LIKE "%- 85 -%" THEN f_votre_club END) AS dept_85
            FROM phpboost_member_extended_fields)
        ');

        while ($row = $req->fetch())
        {
            foreach ($row as $club_number)
            {
                $data[] = $club_number;
            }
            return $data;
        }
        $req->dispose();
    }

    public static function get_registred_clubs_by_dept($dept)
    {
        if ($dept != '00')
        {
            $req = self::$db_querier->select('SELECT f_votre_club, m.display_name, m.user_groups, f_dirigeant_de_club 
                FROM ' . DB_TABLE_MEMBER . ' m
                LEFT JOIN ' . DB_TABLE_MEMBER_EXTENDED_FIELDS . ' me ON m.user_id = me.user_id
                WHERE me.f_votre_club LIKE "%- ' . $dept . ' -%"
                ORDER BY me.f_votre_club, m.display_name ASC
            ');
        } else
        {
            $req = self::$db_querier->select('SELECT f_votre_club, m.display_name, m.user_groups, f_dirigeant_de_club
                FROM ' . DB_TABLE_MEMBER . ' m
                LEFT JOIN ' . DB_TABLE_MEMBER_EXTENDED_FIELDS . ' me ON m.user_id = me.user_id
                ORDER BY me.f_votre_club, m.display_name ASC
            ');
        }

        while ($row = $req->fetch())
        {
            $data[] = $row;
        }
        return $data;
        $req->dispose();
    }

    public static function get_clubs_with_activity()
    {
        $req = self::$db_querier->select('SELECT pl.lamclubs_id, lc.name, lc.ffam_nb  
            FROM ' . PlanningSetup::$planning_table . ' pl
            LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' lc ON pl.lamclubs_id = lc.club_id 
        ');

        while ($row = $req->fetch())
        {
            foreach ($row as $clubs)
            {
                $data[] = $clubs;
            }
            return $data;
        }
        $req->dispose();
    }

    // requêtes financial

    public static function get_count_clubs_requests()
    {
        $req = self::$db_querier->select('SELECT "Total" AS department,
        COUNT(fr.request_type) AS request_count
        FROM phpboost_lamclubs lc
        LEFT JOIN phpboost_financial_request fr ON fr.lamclubs_id = lc.club_id
        WHERE lc.department IN (44, 49, 53, 72, 85)
        UNION ALL
        SELECT lc.department AS department,
        COUNT(fr.request_type) AS request_count
        FROM phpboost_lamclubs lc
        LEFT JOIN phpboost_financial_request fr ON fr.lamclubs_id = lc.club_id
        WHERE lc.department IN (44, 49, 53, 72, 85)
        GROUP BY lc.department
        ORDER BY 
            CASE 
            WHEN department = "Total" THEN 0
            ELSE 1
            END,
            department;
        ');

        while ($row = $req->fetch())
        {
            $data[] = $row;
        }
        return $data;
        $req->dispose();
    }

    public static function get_clubs_requests()
    {
        $req = self::$db_querier->select('SELECT COUNT(fr.request_type), fr.lamclubs_id  
            FROM ' . FinancialSetup::$financial_request_table . ' fr
            LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' lc ON fr.lamclubs_id = lc.club_id
        ');

        while ($row = $req->fetch())
        {
            $data[] = $row;
        }
        return $data;
        $req->dispose();
    }

    public static function get_budgets_ids_used()
    {
        $req = self::$db_querier->select('SELECT budget_id  
            FROM ' . FinancialSetup::$financial_request_table . ' fr
        ');

        while ($row = $req->fetch())
        {
            foreach ($row as $ids)
            {
                $data[] = $ids;
            }
        }
        return $data;
        $req->dispose();
    }

    public static function get_budgets_used_by_dept()
    {
        $req = self::$db_querier->select('SELECT
            COUNT(fr.request_type) AS request_count
            FROM phpboost_financial_request fr
            LEFT JOIN phpboost_lamclubs lc ON fr.lamclubs_id = lc.club_id
            WHERE lc.department IN (44, 49, 53, 72, 85)
            GROUP BY lc.department
            ORDER BY lc.department
            ');

        while ($row = $req->fetch())
        {
            $data[] = $row;
        }

        return $data;
        $req->dispose();
    }

    private static function generateDays($start, $end)
    {
        $startDate = new DateTime(str_replace('/', '-', $start));
        $endDate = new DateTime(str_replace('/', '-', $end));

        $interval = new DateInterval('P1D'); // 1 day interval
        $datePeriod = new DatePeriod($startDate, $interval, $endDate->modify('+1 day')); // Include end date

        $days = [];
        foreach ($datePeriod as $day)
        {
            $days[] = $day->format('d-m-Y');
        }

        return $days;
    }

    public static function get_dept_dates($param)
    {
        // Création timestamp pour le 31 décembre de l'année précédente à 23:59:59
        // pour ne pas afficher les dates de l'année précédente
        $currentYear = date('Y') - 1;
        $lastDayTimestamp = mktime(22, 59, 60, 12, 30, $currentYear);

        $dates = [];

        try {
            $req = self::$db_querier->select('SELECT lc.name, lc.ffam_nb, pl.rewrited_link, pl.activity_detail, pl.start_date, pl.end_date 
                FROM ' . PlanningSetup::$planning_table . ' pl
                LEFT JOIN ' . LamclubsSetup::$lamclubs_table . ' lc ON pl.lamclubs_id = lc.club_id 
                WHERE lc.department = ' . $param . '
                AND pl.start_date > ' . $lastDayTimestamp . '   
                ORDER BY pl.start_date
            ');

            $nb_rows = $req->get_rows_count();

            while ($row = $req->fetch())
            {
                $start = Date::to_format($row['start_date'], Date::FORMAT_DAY_MONTH_YEAR);
                if ($row['end_date'])
                {
                    $end = Date::to_format($row['end_date'], Date::FORMAT_DAY_MONTH_YEAR);
                    if ($start <= $end)
                    {
                        foreach (self::generateDays($start, $end) as $day)
                        {
                            $row['date'] = str_replace('-', '/', $day);
                            $dates[] = $row;
                        }
                    }
                } else
                {
                    $row['date'] = $start;
                    $dates[] = $row;
                }
            }

            // Tableau pour stocker les dates déjà rencontrées
            $datesTrouvees = [];

            // Tableau pour stocker les dates identiques
            $datesIdentiques = [];

            // Parcourir chaque date du tableau
            foreach ($dates as $date)
            {
                if (in_array($date['date'], $datesTrouvees))
                {
                    // Si la date est déjà dans le tableau, l'ajouter à la liste des dates identiques
                    $datesIdentiques[] = $date['date'];
                } else
                {
                    // Sinon, ajouter la date dans le tableau des dates rencontrées
                    $datesTrouvees[] = $date['date'];
                }
            }
            $datesIdentiques = array_unique($datesIdentiques);

            $real_dates = [];
            foreach ($req as $date)
            {
                $date['warning'] = '';
                $date['start_date'] = Date::to_format($date['start_date'], Date::FORMAT_DAY_MONTH_YEAR);
                $date['end_date'] = $date['end_date'] ? Date::to_format($date['end_date'], Date::FORMAT_DAY_MONTH_YEAR) : '-';
                if (in_array($date['start_date'], $datesIdentiques))
                {
                    $index = array_search($date['start_date'], $datesIdentiques);
                    $date['warning'] = $index;
                }
                $real_dates[] = $date;
            }

            usort($real_dates, function ($a, $b) {
                return $a['ffam_nb'] - $b['ffam_nb'];
            });

            // Afficher les dates identiques
            if (!empty($datesIdentiques))
            {
                return new JSONResponse(array('nb_rows' => $nb_rows, 'dates' => $real_dates, 'check' => 'Dates en doubles', 'values' => $datesIdentiques));
            } else
            {
                return new JSONResponse(array('nb_rows' => $nb_rows, 'dates' => $real_dates, 'check' => 'Pas de doublons'));
            }
        } catch (Exception $e) {
            
            }
    }
}
?>