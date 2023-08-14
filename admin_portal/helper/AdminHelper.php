<?php
error_reporting(0);
class AdminHelper
{
    // This function is used to get the total number of users registered or active on a daily basis.
    public static function getDailyVisitorCount($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT COUNT(*) AS row_count FROM login_history WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Access the count value
            $rowCount = 0; //By default rowCount is 0
            $rowCount = $result['row_count'];
            
            // Close the database connection
            $db  = null;
            return $rowCount;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }

    // This function is used to get the total number of users id visited in weekly basis.
    public static function getWeeklyVisitedUserIds($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT id FROM login_history WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the total number of users id visited in monthly basis. by month not days interval
    public static function getMonthlyVisitedUserIds($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve user IDs for the current month 
            $sql = "SELECT id FROM login_history WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get dividends earned by users on a daily basis
    public static function getUserDividendOnDailyBasis($db) {
        $totalEligibleShares = 0;
    
        // Get Sum of eligible_shares as total_eligible_shares from user_registration with a condition that the "threex_amount" column is greater than or equal to the "threex_amount_limit" column.
        $query = "SELECT SUM(eligible_shares) AS total_eligible_shares 
                    FROM user_registration 
                    WHERE threex_amount >= threex_amount_limit";
    
        // Prepare the statement
        $stmt = $db->prepare($query);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results
        $row = $stmt->fetch();
    
        // Set the total_eligible_shares variable
        $totalEligibleShares = $row['total_eligible_shares'];
    
        // Getting all columns from user_pool_amount Where and storing last stored value using loops
        $getpooldetails = "SELECT * FROM `user_pool_amount` WHERE 1";
    
        // Prepare the statement
        $stmt = $db->prepare($getpooldetails);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results
        while ($row = $stmt->fetch()) {
            $total_pool_amount = $row['total_pool_amount'];
            $total_sale_amount = $row['total_sale_amount'];
            $old_share = $row['old_share'];
            $todays_share = $row['todays_share'];
        }
    
        // If total_pool_amount > 0
        if ($total_pool_amount > 0) {
            // echo "Pool Bonus Distributed Successfully!";echo "</br>";
            $total_share = ($total_sale_amount / 50);
    
            // Initial value
            if ($old_share == 0) {
                // First day value when old_share is 0
                // Share amount to distribute users
                return $share_amount = ($total_pool_amount / $total_share);
            } else {
                if ($totalEligibleShares > 0) {
                    // 3x reached share removed to give them others from pools because we are including pools bonus for all including (3x reached)
                    $finalShare = ($old_share + $todays_share) - $totalEligibleShares;
                } else {
                    // If no one reached 3x thann final share
                    $finalShare = $old_share + $todays_share;
                }
                return $share_amount = ($total_pool_amount / $finalShare);
            }
        } else {
            $total_share = 0;
            return $share_amount = 0;
        }
    }


    // This function is used to get the users registered or active on a daily basis.
    public static function getDailyVisitorsLoginHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM login_history WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }


    // This function is used to get the users id visited in weekly basis.
    public static function getWeeklyVisitorsLoginHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM login_history WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    // This function is used to get the users  visited in monthly basis. by month not days interval
    public static function getMonthlyVisitorsLoginHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve  for the current month 
            $sql = "SELECT * FROM login_history WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    // This function is used to get the user's packages history on a daily basis.
    public static function getDailyUserPackageHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM package_details WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's packages history in weekly basis.
    public static function getWeeklyUserPackageHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM package_details WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's packages history in monthly basis. by month not days interval
    public static function getMonthlyUserPackageHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM package_details WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalUserPackageHistory($db, $start_date, $end_date) {
        try {
            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM package_details WHERE date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    

    // This function is used to get the user's internal wallet transfer history on a daily basis.
    public static function getDailyInternalWalletTransferHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM wallet_summary WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's internal wallet transfer history in weekly basis.
    public static function getWeeklyInternalWalletTransferHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM wallet_summary WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's internal wallet transfer history in monthly basis. by month not days interval
    public static function getMonthlyInternalWalletTransferHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM wallet_summary WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's  withdrawal history on a daily basis.
    public static function getDailyUserWithdrawalHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM withdrawal  WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's  withdrawal history in weekly basis.
    public static function getWeeklyUserWithdrawalHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM withdrawal WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's  withdrawal history in monthly basis. by month not days interval
    public static function getMonthlyUserWithdrawalHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM withdrawal WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalUserWithdrawalHistory($db, $start_date, $end_date) {
        try {
            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM withdrawal WHERE date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    // This function is used to get the user's level bonus history on a daily basis.
    public static function getDailyUserLevelBonusHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM bonuses_details  WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's level bonus history in weekly basis.
    public static function getWeeklyUserLevelBonusHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM bonuses_details WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's level bonus history in monthly basis. by month not days interval
    public static function getMonthlyUserLevelBonusHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM bonuses_details WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public static function getIntervalUserLevelBonusHistory($db, $start_date, $end_date) {
        try {
            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM bonuses_details WHERE date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's pool bonus history on a daily basis.
    public static function getDailyUserPoolBonusHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM user_pool_amount_history  WHERE pool_date >= NOW() - INTERVAL 1 DAY AND pool_date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's level bonus history in weekly basis.
    public static function getWeeklyUserPoolBonusHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM user_pool_amount_history WHERE pool_date >= CURDATE() - INTERVAL 7 DAY ORDER BY pool_date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's level bonus history in monthly basis. by month not days interval
    public static function getMonthlyUserPoolBonusHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM user_pool_amount_history WHERE MONTH(pool_date) = :monthNumber AND YEAR(pool_date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the total number of users registered or active on a daily basis.
    public static function getDailyRegisteredUserCount($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT COUNT(*) AS row_count FROM user_registration WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Access the count value
            $rowCount = 0; //By default rowCount is 0
            $rowCount = $result['row_count'];
            
            // Close the database connection
            $db  = null;
            return $rowCount;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }


    public static function getDailyUserDepositHistroy($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT COUNT(*) AS row_count FROM package_details WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);    
            // Access the count value
            $rowCount = 0; //By default rowCount is 0
            $rowCount = $result['row_count'];        
            // Close the database connection
            $db  = null;
            return $rowCount;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }

     // This function is used to get the user's  withdrawal history on a daily basis.
     public static function getDailyUserWithdrawalCountHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT COUNT(*) AS row_count FROM withdrawal  WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);            
             // Access the count value
             $rowCount = 0; //By default rowCount is 0
             $rowCount = $result['row_count'];        
             // Close the database connection
             $db  = null;
             return $rowCount;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }

    public static function getDailyAdminGtronWalletHistory($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM admin_gtron_wallet  WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }

    public static function getWeeklyAdminGtronWalletHistory($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM admin_gtron_wallet WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getMonthlyAdminGtronWalletHistory($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve user IDs for the current month 
            $sql = "SELECT * FROM admin_gtron_wallet WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalAdminGtronWalletHistory($db, $start_date, $end_date) {
        try {
            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM admin_gtron_wallet WHERE date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public static function getAdminWalletSummary($db) {
        try {
            // Get the current month and year
            $sql = "SELECT * FROM admin_wallet_summary ";

            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getGtronProfitReport($db) {
        try {
            // Get the current timestamp
            $sql = "SELECT * FROM package_details  WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
            // // Get the current month and year
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getWeeklyGtronProfitReport($db) {
        try {
            // Get the current month and year
             // SQL query to retrieve data from the last 7 days with a weekly interval
             $sql = "SELECT * FROM package_details WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
             // Prepare the statement
             $stmt = $db->prepare($sql);
             // Execute the query
             $stmt->execute();
             // Fetch the results as associative array
             $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
             // Close the database connection
             $db  = null;
             return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getMonthlyGtronProfitReport($db) {
        try {
            // // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM package_details WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalGtronProfitReport($db, $start_date, $end_date) {
        try {
            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM package_details WHERE date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getGtronTokenWalletSummary($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT SUM(gtron_wallet) AS gtron_wallet_sum FROM wallet_summary ";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Access the count value
            $rowCount = 0; //By default rowCount is 0
            $rowCount = $result['gtron_wallet_sum'];
            
            // Close the database connection
            $db  = null;
            return $rowCount;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }


    public static function getAllInfoGtronTokenWalletSummary($db) {
		try {
            $sql = "SELECT * FROM wallet_summary";

            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }


    // This function is used to get the user's pool bonus history on a daily basis.
    public static function getDailyUserDividendReport($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM wallet_summary  WHERE date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's level bonus history in weekly basis.
    public static function getWeeklyUserDividendReport($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM wallet_summary WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's level bonus history in monthly basis. by month not days interval
    public static function getMonthlyUserDividendReport($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM wallet_summary WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalUserDividendReport($db, $start_date, $end_date) {
        try {
            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM wallet_summary WHERE date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public static function getDailyUserDividendBonus($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM wallet_summary  WHERE credit_type = 'pool_bonus' AND date >= NOW() - INTERVAL 1 DAY AND date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's level bonus history in weekly basis.
    public static function getWeeklyUserDividendBonus($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM wallet_summary WHERE credit_type = 'pool_bonus' AND date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's level bonus history in monthly basis. by month not days interval
    public static function getMonthlyUserDividendBonus($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM wallet_summary WHERE credit_type = 'pool_bonus' AND MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalUserDividendBonus($db, $start_date, $end_date) {
        try {
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM wallet_summary WHERE credit_type = 'pool_bonus' AND date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


     // This function is used to get the user's internal wallet transfer history on a daily basis.
     public static function getDailyInternalWalletTransferLogs($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM wallet_transfer WHERE transaction_date >= NOW() - INTERVAL 1 DAY AND 	transaction_date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's internal wallet transfer history in weekly basis.
    public static function getWeeklyInternalWalletTransferLogs($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM wallet_transfer WHERE transaction_date >= CURDATE() - INTERVAL 7 DAY ORDER BY transaction_date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's internal wallet transfer history in monthly basis. by month not days interval
    public static function getMonthlyInternalWalletTransferLogs($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM wallet_transfer WHERE MONTH(transaction_date) = :monthNumber AND YEAR(transaction_date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getIntervalInternalWalletTransferLogs($db, $start_date, $end_date) {
        try {

            // SQL query to retrieve for the current month 
            $start_datetime = $start_date . " 00:00:00";
            $end_datetime = $end_date . " 23:59:59";

            $sql = "SELECT * FROM wallet_transfer WHERE transaction_date BETWEEN :start_date AND :end_date";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':start_date', $start_datetime, PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $end_datetime, PDO::PARAM_STR);
            $stmt->execute();

            // Execute the query
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
            // // Get the current month and year
            // $currentMonth = date('m');
            // $currentYear = date('Y');

            // // SQL query to retrieve for the current month 
            // $sql = "SELECT * FROM wallet_transfer WHERE MONTH(transaction_date) = :monthNumber AND YEAR(transaction_date) = :yearNumber";

            // // Prepare the statement
            // $stmt = $db->prepare($sql);

            // // Bind the values to the placeholders
            // $stmt->bindParam(':monthNumber', $currentMonth);
            // $stmt->bindParam(':yearNumber', $currentYear);

            // // Execute the query
            // $stmt->execute();
            // $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // // Close the database connection
            // $db  = null;
            // return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's internal wallet transfer history on a daily basis.
    public static function getDailyAdminWalletSummaryLogs($db) {
		try {
            // Get the current timestamp
            $sql = "SELECT * FROM admin_wallet_summary_logs WHERE date >= NOW() - INTERVAL 1 DAY AND 	date <= NOW()";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the result
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            // Close the database connection
            $db  = null;
            return $result;
		}
		catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
		}	
    }
    

    // This function is used to get the user's internal wallet transfer history in weekly basis.
    public static function getWeeklyAdminWalletSummaryLogs($db) {
        try {
            // SQL query to retrieve data from the last 7 days with a weekly interval
            $sql = "SELECT * FROM admin_wallet_summary_logs WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Fetch the results as associative array
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Close the database connection
            $db  = null;
            return $results;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the user's internal wallet transfer history in monthly basis. by month not days interval
    public static function getMonthlyAdminWalletSummaryLogs($db) {
        try {
            // Get the current month and year
            $currentMonth = date('m');
            $currentYear = date('Y');

            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM admin_wallet_summary_logs WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

            // Prepare the statement
            $stmt = $db->prepare($sql);

            // Bind the values to the placeholders
            $stmt->bindParam(':monthNumber', $currentMonth);
            $stmt->bindParam(':yearNumber', $currentYear);

            // Execute the query
            $stmt->execute();
            $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $userIDs;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getAdminWalletDetails($db) {
        try {
            // Get the current month and year
            $sql = "SELECT * FROM admin_wallet ";

            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $response;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public static function updateAdminWalletSummeryLogs($db,$gtronAmount,$receiverWalletAddress) {
        try {    
        // Prepare the statement
        $AWS_stmt = $db->prepare("SELECT * FROM `admin_wallet_summary` WHERE wallet_address=:wallet_address");
        $AWS_stmt->bindParam(':wallet_address', $receiverWalletAddress, PDO::PARAM_STR);    
        // Execute the query
        $AWS_stmt->execute();
        // Fetch the results
        $res = $AWS_stmt->fetch(PDO::FETCH_ASSOC); 

        $newAmount = $res['total_amount'] + $res['gtron_commission'];

        $date = date('Y-m-d');
        // Prepare the INSERT statement
        $stmt = $db->prepare("INSERT INTO admin_wallet_summary_logs (owner_id_fk, wallet_address, previous_amount, new_amount, gtron_commission, date) VALUES (:owner_id_fk, :wallet_address,:previous_amount,:new_amount, :gtron_commission, :date)");
        $stmt->bindParam(':owner_id_fk', $res['owner_id']);
        $stmt->bindParam(':wallet_address', $res['wallet_address']);
        $stmt->bindParam(':previous_amount',$res['total_amount']);
        $stmt->bindParam(':new_amount', $newAmount);
        $stmt->bindParam(':gtron_commission', $res['gtron_commission']);
        $stmt->bindParam(':date', $date);

        try {
            // Execute the prepared statement
            $stmt->execute();
            $gtronAmount = 0;
            $sql = "UPDATE admin_wallet_summary SET total_amount = :total_amount, gtron_commission = :gtron_commission, date = :newdate  WHERE wallet_address=:wallet_address AND owner_id = :owner_id_fk ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':total_amount', $newAmount);
            $stmt->bindParam(':gtron_commission', $gtronAmount);  
            $stmt->bindParam(':newdate', $date);  
            $stmt->bindParam(':owner_id_fk', $res['owner_id']);  
            $stmt->bindParam(':wallet_address', $res['wallet_address']);  
            $stmt->execute();
            return "Data inserted successfully.";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
            // Close the database connection
            $db  = null;
            // return $response;
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }


    public static function getNewRegisteredUserDetails($db) {
        try {
            // SQL query to retrieve for the current month 
            $sql = "SELECT * FROM pre_registration  ORDER BY id DESC";

            // Prepare the statement
            $stmt = $db->prepare($sql);
            // Execute the query
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Close the database connection
            $db  = null;
            return $res;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // This function is used to get the total number of users id visited in weekly basis.
    // public static function getWeeklyRegisteredUserCount($db) {
    //     try {
    //         // SQL query to retrieve data from the last 7 days with a weekly interval
    //         $sql = "SELECT id FROM user_registration WHERE date >= CURDATE() - INTERVAL 7 DAY ORDER BY date DESC";
    //         // Prepare the statement
    //         $stmt = $db->prepare($sql);
    //         // Execute the query
    //         $stmt->execute();
    //         // Fetch the results as associative array
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //         // Close the database connection
    //         $db  = null;
    //         return $results;
    //     } catch (PDOException $e) {
    //         echo "Connection failed: " . $e->getMessage();
    //     }
    // }

    // This function is used to get the total number of users id visited in monthly basis. by month not days interval
    // public static function getMonthlyRegisteredUserCount($db) {
    //     try {
    //         // Get the current month and year
    //         $currentMonth = date('m');
    //         $currentYear = date('Y');

    //         // SQL query to retrieve user IDs for the current month 
    //         $sql = "SELECT id FROM user_registration WHERE MONTH(date) = :monthNumber AND YEAR(date) = :yearNumber";

    //         // Prepare the statement
    //         $stmt = $db->prepare($sql);

    //         // Bind the values to the placeholders
    //         $stmt->bindParam(':monthNumber', $currentMonth);
    //         $stmt->bindParam(':yearNumber', $currentYear);

    //         // Execute the query
    //         $stmt->execute();
    //         $userIDs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         // Close the database connection
    //         $db  = null;
    //         return $userIDs;
    //     } catch (PDOException $e) {
    //         echo "Connection failed: " . $e->getMessage();
    //     }
    // }
    
}

?>