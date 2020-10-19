<?php
require_once('dbh.php');

class Child extends Dbh
{
    //Insert child
    public function insert($fname, $lname,  $father_name,  $grandfather_name,  $gender,  $phone_num,  $dateofbirth,  $placeofbirth,  $address,  $numoffamily,  $numofsis, $numofbro,  $ssn,  $school_name,  $class,  $reasonofschool_leaving, $job,  $incomeperday,  $houseliving,  $sickness,  $bloodgroup,  $otherfamilymembers,  $desc,  $skills,  $interests)
    {
        $sql = "INSERT INTO `child`(`id`, `fname`, `lname`, `father_name`, `Grandfather_name`, `gender`, `phone_num`, `dateofbirth`, `placeofbirth`, `address`, `numoffamily`, `numofsis`, `numofbro`, `ssn`, `school_name`, `Class`, `reasonofschool_leaving`, `job`, `incomeperday`, `houseliving`, `sickness`, `bloodgroup`, `otherfamilymembers`, `desc`, `skills`, `interests`) VALUES (NULL, '$fname','$lname','$father_name','$grandfather_name','$gender',$phone_num,'$dateofbirth','$placeofbirth','$address','$numoffamily','$numofsis','$numofbro','$ssn','$school_name','$class','$reasonofschool_leaving','$job','$incomeperday','$houseliving','$sickness','$bloodgroup','$otherfamilymembers','$desc','$skills','$interests');

        ";
        
        $this->execute($sql);

        $sql2 = "SELECT LAST_INSERT_ID()";
        

        return $this->execute($sql2);


    }

    public function insert_child_program($child_id, $program_id)
    {
        $sql = "INSERT INTO `child_register_programs`(`Program_id`, `Child_id`) VALUES ('$program_id','$child_id')";

        
        return $this->execute($sql);
    }

    //Duplicate checking of child
    public function is_child($fname, $lname, $father_name)
    {
        $sql = "SELECT * FROM child WHERE fname = '$fname' AND lname = '$lname' AND father_name = '$father_name' ";

        return $this->fetchResult($sql);
    }

    //Selecting all children
    public function select_all()
    {
        $sql = "SELECT * FROM child";

        return $this->fetchResult($sql);
    }

    public function count_children()
    {
        $sql = "SELECT COUNT(*) FROM `child`";

        return $this->fetchResult($sql);
    }

    //Select child specification by id
    public function select_child_by_id($child_id)
    {
        $sql = "SELECT * FROM `child` WHERE id = '$child_id'";

        return $this->fetchResult($sql);
    }

    //Deleting child by id
    public function delete_child_by_id($child_id)
    {
        $sql = "DELETE FROM `child` WHERE id = '$child_id'";

        return $this->execute($sql);
    }

    //Deleting child by id
    public function delete_stationary_by_id($stationary_id)
    {
        $sql = "DELETE FROM `give_products` WHERE id = '$stationary_id'";
        echo $sql;
        die;
        return $this->execute($sql);
    }

    public function delete_donated_by_id($donate_id)
    {
        $sql = "DELETE FROM `registration_products` WHERE id = '$donate_id'";
  
        return $this->execute($sql);
    }



    //CHILD STATIONRY PLAN
    //Give each child stationary items 
    public function select_child_stationary($child_id)
    {
        $sql = "SELECT give_products.id as give_pro_id, give_products.quantity, give_products.date, stationary.id, stationary.name  FROM give_products JOIN stationary ON give_products.registration_products_id = stationary.id WHERE Child_id = '$child_id' and give_products.type='stationary' and office='no'";

        return $this->fetchResult($sql);
    }

    public function select_office_stationary($child_id)
    {
        $sql = "SELECT give_products.id, give_products.quantity, give_products.date, stationary.id, stationary.name  FROM give_products JOIN stationary ON give_products.registration_products_id = stationary.id WHERE office = 'yes' and give_products.type='stationary'";

        return $this->fetchResult($sql);
    }


    public function insert_child_stationary($child_id, $name, $quantity, $date)
    {
        $sql = "INSERT INTO `give_products`(`quantity`, `date`, `registration_products_id`, `Child_id`, `Needy_Person_idNeedy_Person`, `type`) VALUES ('$quantity', '$date', '$name', '$child_id', 0, 'stationary')";

        return $this->execute($sql);
    }

    public function insert_office_stationary($name, $quantity, $date)
    {
        $sql = "INSERT INTO `give_products`(`quantity`, `date`, `registration_products_id`, `Child_id`, `Needy_Person_idNeedy_Person`, `type`, office) VALUES ('$quantity', '$date', '$name', 0, 0, 'stationary', 'yes')";

        return $this->execute($sql);
    }



    //CHILD CLOTHES PLAN
    //Give each child clothes items
    public function select_child_clothes($child_id)
    {
        $sql = "SELECT give_products.id as give_pro_id, give_products.quantity, give_products.date, clothes.id, clothes.name, clothes.type, clothes.season  FROM give_products JOIN clothes ON give_products.registration_products_id = clothes.id WHERE Child_id = '$child_id' and give_products.type='clothes'";

        return $this->fetchResult($sql);
    }

    public function insert_child_clothes($child_id, $clothe_id, $quantity, $date)
    {
        $sql = "INSERT INTO `give_products`(`quantity`, `date`, `registration_products_id`, `Child_id`, `Needy_Person_idNeedy_Person`,`type`) VALUES ('$quantity', '$date', '$clothe_id', '$child_id', 0,'clothes')";

        return $this->execute($sql);
    }

    //Needy person
    public function select_needy_person()
    {
        $sql = "SELECT * FROM `needy_person`";

        return $this->fetchResult($sql);
    }

    public function count_needy_person()
    {
        $sql = "SELECT COUNT(*) FROM `needy_person`";

        return $this->fetchResult($sql);
    }

    public function check_needy_person($fname, $lname, $referal)
    {
        $sql = "SELECT * FROM `needy_person` WHERE fname='$fname' and lname='$lname' and referal='$referal'";

        return $this->fetchResult($sql);
    }

    public function insert_needy_person($fname, $lname, $dob, $phone_num, $placeofbirth, $address, $referal)
    {
        $sql = "INSERT INTO `needy_person`(`fname`, `lname`, `DOB`, `phone_num`, `placeofbirth`, `address`, `referal`) VALUES ('$fname','$lname','$dob','$phone_num','$placeofbirth','$address','$referal')";

        return $this->fetchResult($sql);
    }

    public function delete_needy_by_id($id)
    {
        $sql = "DELETE FROM needy_person WHERE id = $id";

        return $this->execute($sql);
    }

    public function insert_needy_clothes($needy_id, $clothe_id, $quantity, $date)
    {
        $sql = "INSERT INTO `give_products`(`quantity`, `date`, `registration_products_id`, `Child_id`, `Needy_Person_idNeedy_Person`,`type`) VALUES ('$quantity', '$date', '$clothe_id', 0, $needy_id,'clothes')";

        return $this->execute($sql);
    }

     public function select_needy_by_id($needy_id)
    {
        $sql = "SELECT * FROM `needy_person` WHERE idNeedy_Person = '$needy_id'";

        return $this->fetchResult($sql);
    }

    public function select_needy_clothes($needy_id)
    {
        $sql = "SELECT give_products.id, give_products.quantity, give_products.date, clothes.id, clothes.name, clothes.type, clothes.season  FROM give_products JOIN clothes ON give_products.registration_products_id = clothes.id WHERE Needy_Person_idNeedy_Person = '$needy_id' and give_products.type='clothes' and office='no'";

        return $this->fetchResult($sql);
    }


    //CHILD RELATIVES
    //Checking child relatives duplication
    public function has_relative($child_id, $fname)
    {
        $sql = "SELECT * FROM `relatives` WHERE Child_id = '$child_id' and fname = '$fname'";

        return $this->fetchResult($sql);
    }


    //CHILD RELATIVES
    //Inserting child relatives
    public function insert_relatives($child_id, $fname, $lname, $father_name, $dob, $job, $incomeperday, $class, $school, $relation_status, $maritalstatus, $is_responsible)
    {
        $sql = "INSERT INTO `relatives`(`fname`, `lname`, `fathername`, `DOB`, `job`, `incomeperday`, `class`, `school`, `relation_status`, `maritalstatus`, `Is_responsible`, `Child_id`) VALUES ('$fname','$lname','$father_name','$dob','$job','$incomeperday','$class','$school','$relation_status','$maritalstatus','$is_responsible',$child_id)";
       
        return $this->execute($sql);
    }

    //Select All relatives 
    public function select_relatives()
    {
        $sql = "SELECT relatives.id, relatives.fname, relatives.fathername, relatives.job, relatives.incomeperday, relatives.relation_status, relatives.Child_id, child.fname as 'child_name', child.lname FROM relatives JOIN child on relatives.Child_id = child.id ";

        return $this->fetchResult($sql);
    }


    //PROGRAMS
    //inserting new program
    public function insert_program($name, $description, $status, $established_date)
    {
        $sql = "INSERT INTO `program`(`name`, `description`, `status`, `established_date`) VALUES ('$name','$description','$status','$established_date')";

        return $this->execute($sql);
    }

    public function select_program()
    {
        $sql = "SELECT * FROM `program`";

        return $this->fetchResult($sql);
    }

    public function count_program()
    {
        $sql = "SELECT COUNT(*) FROM `program`";

        return $this->fetchResult($sql);
    }


    //STATIONARY
    //Insert new stationary
    public function insert_stationary($name, $code, $description)
    {
        $sql = "INSERT INTO `stationary`( `name`, `code`,  `description`) VALUES ('$name','$code','$description')";
        
        return $this->execute($sql);
    }

    //Select Stationary 
    public function select_stationary()
    {
        $sql = "SELECT * FROM stationary";

        return $this->fetchResult($sql);
    }

    public function count_stationary_purchased()
    {
        $sql = "SELECT COUNT(quantity) FROM `registration_products` WHERE clothes_id = 0 AND type='purchased'";

        return $this->fetchResult($sql);
    }

    public function count_stationary_sale()
    {
        $sql = "SELECT COUNT(quantity) FROM `registration_products` WHERE clothes_id = 0 AND type='sales'";

        return $this->fetchResult($sql);
    }

    //Delete stationary item
    public function delete_stationary($stationary_id)
    {
        $sql = "DELETE FROM stationary WHERE id = '$stationary_id'";

        return $this->execute($sql);
    }


    //CLOTHES
    //Insert new Clothes
    public function insert_clothe($name, $section, $specification, $season, $type)
    {
        $sql = "INSERT INTO `clothes`(`name`, `section`, `specification`, `season`, `type`) VALUES ('$name','$section','$specification','$season','$type')";

        return $this->execute($sql);
    }

    //Select all from clothes
    public function select_clothes()
    {
        $sql = "SELECT * FROM clothes";

        return $this->fetchResult($sql);
    }

    public function select_clothes_name()
    {
        $sql = "SELECT  DISTINCT(name) FROM clothes";

        return $this->fetchResult($sql);
    }

    public function select_clothes_section()
    {
        $sql = "SELECT  DISTINCT(section) FROM clothes";

        return $this->fetchResult($sql);
    }

    public function select_clothes_season()
    {
        $sql = "SELECT  DISTINCT(season) FROM clothes";

        return $this->fetchResult($sql);
    }

    public function select_clothes_type()
    {
        $sql = "SELECT  DISTINCT(type) FROM clothes";

        return $this->fetchResult($sql);
    }

    public function count_clothes_pruchased()
    {
        $sql = "SELECT COUNT(quantity) FROM `registration_products` WHERE stationary_id = 0 AND type='purchased'";

        return $this->fetchResult($sql);
    }

    public function count_clothes_sale()
    {
        $sql = "SELECT COUNT(quantity) FROM `registration_products` WHERE stationary_id = 0 AND type='sales'";

        return $this->fetchResult($sql);
    }

    //Delete clothes 
    public function delete_clothe($clothe_id)
    {
        $sql = "DELETE FROM clothes WHERE id = '$clothe_id'";

        return $this->execute($sql);
    }


    //REGISTERATION PRODUCTS
    //Insert registeration products
    public function insert_registeration_products_stationary($name, $stock, $quantity, $price, $type, $date)
    {
        $sql = "INSERT INTO `registration_products`(`type`, `Stock_id`, `quantity`, `unit_price`, `date`, `stationary_id`) VALUES ('$type','$stock','$quantity','$price','$date','$name')";

        return $this->execute($sql);
    }

    public function insert_registeration_products_clothes($name, $stock, $quantity, $price, $type, $date)
    {
        $sql = "INSERT INTO `registration_products`(`type`, `Stock_id`, `quantity`, `unit_price`, `date`, `clothes_id`) VALUES ('$type','$stock','$quantity','$price','$date','$name')";
    
        return $this->execute($sql);
    }

    public function clothe_id($name, $clothe_season, $clothe_type)
    {
        $sql = "SELECT id FROM `clothes` WHERE name='$name' AND season='$clothe_season' AND type='$clothe_type'";
        // echo $sql;
        // die;

        return $this->fetchResult($sql);
    }
    public function select_registeration_product()
    {
        $sql = "SELECT  stationary.name as 'stationary_name', registration_products.type, registration_products.id as regis_id, stock.name as 'stock_name', registration_products.quantity, registration_products.unit_price, registration_products.date FROM registration_products 
        JOIN stationary on registration_products.stationary_id = stationary.id
        JOIN stock on registration_products.Stock_id = stock.id where stock.name='گدام عمومی' and registration_products.unit_price <> 'donated'" ;

        return $this->fetchResult($sql);
    }

    public function select_donated_registeration_product()
    {
        $sql = "SELECT stationary.name as 'stationary_name', registration_products.type, registration_products.id as regis_id, stock.name as 'stock_name', registration_products.quantity, registration_products.unit_price, registration_products.date FROM registration_products 
        JOIN stationary on registration_products.stationary_id = stationary.id
        JOIN stock on registration_products.Stock_id = stock.id WHERE unit_price = 'donated' and stock.name='گدام اهدایی'";

        return $this->fetchResult($sql);
    }

    //registeration products for  clothes
    public function select_registeration_product_clothes()
    {
        $sql = "SELECT registration_products.type, stock.name as 'stock_name', registration_products.quantity, registration_products.unit_price, registration_products.id as regis_id, registration_products.date, clothes.name as 'clothe_name', clothes.season as 'season'
        FROM registration_products 
        JOIN stock on registration_products.Stock_id = stock.id
        JOIN clothes on registration_products.clothes_id = clothes.id  where stock.name='گدام عمومی' and registration_products.unit_price <> 'donated'";

        return $this->fetchResult($sql);
    }

    //registeration products for  clothes
    public function select_donated_registeration_product_clothes()
    {
        $sql = "SELECT registration_products.type, registration_products.id as regis_id, stock.name as 'stock_name', registration_products.quantity, registration_products.unit_price, registration_products.date, clothes.name as 'clothe_name', clothes.season as 'season'
        FROM registration_products 
        JOIN stock on registration_products.Stock_id = stock.id
        JOIN clothes on registration_products.clothes_id = clothes.id  WHERE unit_price='donated' and stock.name='گدام اهدایی'";

        return $this->fetchResult($sql);
    }

    //Sum of all stationary price
    public function select_all_stationary_price()
    {
        $sql = "SELECT (SUM(quantity * unit_price)) AS price FROM registration_products WHERE clothes_id = 0";

        return $this->fetchResult($sql);
    }

    //Sum of all clothes price
    public function select_all_clothes_price()
    {
        $sql = "SELECT (SUM(quantity * unit_price)) AS price FROM registration_products WHERE stationary_id = 0";

        return $this->fetchResult($sql);
    }


    //STOCK
    //Select all stocks 
    public function select_stock()
    {
        $sql = "SELECT * FROM stock";

        return $this->fetchResult($sql);
    }


    //SURVEY
    //Insert survey
    public function insert_survey($child_id, $su_name, $su_date, $responsible_person, $attachment, $description)
    {
        $sql = "INSERT INTO `survey`(`su_name`, `date`, `responsible_person`, `attachment`, `description`, `Child_id`) VALUES ('$su_name','$su_date','$responsible_person','$attachment','$description',$child_id)";

        return $this->execute($sql);
    }


    //OFFICE SUPPLIES
    //Insert office supplies
    public function insert_office_supplies($name, $specification, $responsible_person, $section, $stock, $type, $status)
    {
        $sql = "INSERT INTO `office_supplies`(`name`, `specification`, `responsible_person`, `section`, `Stock_id`, `type`, `status`) VALUES ('$name','$specification','$responsible_person','$section','$stock','$type','$status')";

        return $this->execute($sql);
    }

    //select all office supplies
    public function select_office_supplies()
    {
        $sql = "SELECT name, specification, responsible_person, section, quantity, unit_price, date  FROM `office_supplies` JOIN suplies_transaction ON office_supplies.id = suplies_transaction.Office_Supplies_id;";

        return $this->fetchResult($sql);
    }

    //Checks whierter the office item already exist or not If it then returns the office_supply id field to be inserted in suplies_transaction
    public function check_office_items($name, $specification, $responsible_person, $section, $stock, $type, $status)
    {
        $sql = "SELECT id FROM `office_supplies` WHERE name = '$name' AND specification = '$specification' AND responsible_person = '$responsible_person' AND section = '$section' AND Stock_id = '$stock' AND type = '$type' AND status = '$status'";
       
        return $this->fetchResult($sql);
    }

    //Sum of all products price
    public function select_all_price()
    {
        $sql = "SELECT (SUM(quantity *unit_price)) AS price  FROM suplies_transaction";

        return $this->fetchResult($sql);
    }
    
    //SUPLIES TRANSACTIONS
    public function insert_suplies_transaction($office_id, $quantity, $date, $unit_price, $type)
    {
        $sql = "INSERT INTO `suplies_transaction`(`Office_Supplies_id`, `quantity`, `date`, `unit_price`, `type`) VALUES ('$office_id','$quantity','$date','$unit_price','$type')";

        return $this->execute($sql);
    }


    //Loggin and registeration
    public function login($username, $password, $type)
    {
        $sql = "SELECT * FROM user WHERE username = '$username' and password = '$password' and type='$type'";

        return $this->fetchResult($sql);
    }

    //check if user exist
    public function is_user($username, $password)
    {
        $sql = "SELECT * FROM user WHERE username = '$username' and password = '$password'";

        return $this->fetchResult($sql);
    }


    public function register_user($username, $password, $register_date, $notes, $email, $type)
    {
        $sql = "INSERT INTO `user`(`username`, `password`, `register_date`, `notes`, `email`, `type`) VALUES ('$username','$password','$register_date','$notes','$email','$type')";

        return $this->execute($sql);
    }

    public function select_users()
    {
        $sql = "SELECT * FROM `user`";

        return $this->fetchResult($sql);
    }

    public function count_users()
    {
        $sql = "SELECT COUNT(*) FROM `user`";

        return $this->fetchResult($sql);
    }

    //REPORT SECTION
    //Count child based on gender
    public function select_gender_girl()
    {
        $sql = "SELECT COUNT(*) as 'girls' FROM child WHERE gender='دختر'";

        return $this->fetchResult($sql);
    }

    public function select_gender_boy()
    {
        $sql = "SELECT COUNT(*) as 'boys' FROM child WHERE gender='پسر'";

        return $this->fetchResult($sql);
    }

    public function select_ages()
    {
        $sql = "SELECT DISTINCT(YEAR(dateofbirth)) AS 'year' FROM child ORDER BY dateofbirth
        ";

        return $this->fetchResult($sql);
    }

    public function select_age_children_boys($year)
    {
        
        $sql = "SELECT COUNT(*) as 'boy' FROM child WHERE YEAR(dateofbirth) = '$year' AND gender ='پسر'";
        
        return $this->fetchResult($sql);
    }

    public function select_age_children_girls($year)
    {
        
        $sql = "SELECT COUNT(*) AS 'girls' FROM child WHERE YEAR(dateofbirth) = $year AND gender ='دختر'";

        return $this->fetchResult($sql);
    }

    public function select_places()
    {
        $sql = "SELECT DISTINCT(placeofbirth) as 'place'  FROM child WHERE gender='دختر'";

        return $this->fetchResult($sql);
    }

    public function select_places_girls($place)
    {
        
        $sql = "SELECT COUNT(*) AS 'girls' FROM child WHERE placeofbirth = '$place' AND gender ='دختر'";

        return $this->fetchResult($sql);
    }

    public function select_places_boys($place)
    {
        
        $sql = "SELECT COUNT(*) AS 'boys' FROM child WHERE placeofbirth = '$place' AND gender ='پسر'";

        return $this->fetchResult($sql);
    }

    public function select_jobs()
    {
        $sql = "SELECT DISTINCT(job) as 'jobs' FROM child";

        return $this->fetchResult($sql);
    }

    public function select_jobs_girls($job)
    {
        $sql = "SELECT count(*) as 'girls' FROM child WHERE  job ='$job' AND gender ='دختر'";

        return $this->fetchResult($sql);
    }
    public function select_jobs_boys($job)
    {
        $sql = "SELECT count(*) as 'boys' FROM child WHERE job ='$job' AND gender ='پسر'";

        return $this->fetchResult($sql);
    }
    
    public function select_stationary_items()
    {
        $sql = "SELECT name, id  FROM stationary";

        return $this->fetchResult($sql);
    }

    public function select_stationary_item_quantiy($stationary_id)
    {
        $sql = "SELECT SUM(quantity) as quantity FROM `registration_products` WHERE stationary_id = '$stationary_id'";

        return $this->fetchResult($sql);
    }

    public function select_registration_stationary_given_items($stationary_id)
    {
        $sql = "SELECT sum(quantity) as 'quantity'  FROM `give_products` WHERE  registration_products_id = $stationary_id and type='stationary'";

        return $this->fetchResult($sql);
    }
    public function select_registration_clothes_given_items($clothes_id)
    {
        $sql = "SELECT sum(quantity) as 'quantity'  FROM `give_products` WHERE  registration_products_id = $clothes_id and type='clothes' and office='no'";

        return $this->fetchResult($sql);
    }

    public function select_clothes_items()
    {
        $sql = "SELECT * FROM clothes";

        return $this->fetchResult($sql);
    }

    public function select_clothes_item_quantiy($clothes_id)
    {
        $sql = "SELECT SUM(quantity) as quantity FROM `registration_products` WHERE clothes_id = '$clothes_id'";

        return $this->fetchResult($sql);
    }

    // public function select_clothes_given_items($registration_product_id)
    // {
    //     $sql = "SELECT SUM(quantity) as 'quantity'  FROM give_products  WHERE registration_products_id = '$registration_product_id'";

    //     return $this->fetchResult($sql);
    // }

    public function select_sum_registeration_stationary()
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM registration_products where clothes_id = 0";

        return $this->fetchResult($sql);
    }

    public function select_sum_registeration_clothes()
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM registration_products where stationary_id = 0";

        return $this->fetchResult($sql);
    }

    public function select_sum_given_products_stationary()
    {
        $sql = "SELECT sum(quantity) as 'quantity'  FROM `give_products` WHERE type='stationary'";

        return $this->fetchResult($sql);
    }

    public function select_sum_given_products_clothes()
    {
        $sql = "SELECT sum(quantity) as 'quantity'  FROM `give_products` WHERE type='clothes'";

        return $this->fetchResult($sql);
    }

    public function select_count_programs()
    {
        $sql = "SELECT count(*) as 'programs' FROM program";

        return $this->fetchResult($sql);
    }

    public function select_stationary_date_report($from_date, $to_date)
    {
        $sql = "SELECT sum(quantity) as 'quantity' FROM `registration_products` WHERE (date BETWEEN '$from_date' AND '$to_date') AND clothes_id=0";

        return $this->fetchResult($sql);
    }

    public function select_stationary_date_donated_report($from_date, $to_date)
    {
        $sql = "SELECT sum(quantity) as 'quantity' FROM `registration_products` WHERE (date BETWEEN '$from_date' AND '$to_date') AND clothes_id=0 and unit_price='donate'";

        return $this->fetchResult($sql);
    }

    public function select_clothes_date_report($from_date, $to_date)
    {
        $sql = "SELECT sum(quantity)  as 'quantity' FROM `registration_products` WHERE (date BETWEEN '$from_date' AND '$to_date') AND stationary_id=0";
        

        return $this->fetchResult($sql);
    }

    public function select_clothes_date_donated_report($from_date, $to_date)
    {
        $sql = "SELECT sum(quantity)  as 'quantity' FROM `registration_products` WHERE (date BETWEEN '$from_date' AND '$to_date') AND stationary_id=0 and unit_price='donate'";
        

        return $this->fetchResult($sql);
    }

    public function select_registration_clothes_given_each_item($clothes_id, $from_date, $to_date)
    {
        $sql = "SELECT sum(quantity) as 'quantity'  FROM `give_products` WHERE  registration_products_id IN (SELECT registration_products.id FROM registration_products WHERE (clothes_id = '$clothes_id') AND (date BETWEEN '$from_date' AND '$to_date'))";

        return $this->fetchResult($sql);
    }

    public function select_clothes_item_date_report($clothes_id, $from_date, $to_date)
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM `registration_products` WHERE (clothes_id = '$clothes_id' ) AND (date BETWEEN '$from_date' AND '$to_date')";

        return $this->fetchResult($sql);
    }

    public function select_registration_stationary_given_each_item($stationary_id, $from_date, $to_date)
    {
        $sql = "SELECT sum(quantity) as 'quantity'  FROM `give_products` WHERE  registration_products_id IN (SELECT registration_products.id FROM registration_products WHERE (stationary_id = $stationary_id) AND (date BETWEEN '$from_date' AND '$to_date'))";
        
        return $this->fetchResult($sql);
        
    }

    public function select_stationary_item_date_report($stationary_id, $from_date, $to_date)
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM `registration_products` WHERE (stationary_id = '$stationary_id' ) AND (date BETWEEN '$from_date' AND '$to_date')";
      

        return $this->fetchResult($sql);
    }

    

    //RED CRESCENT 
    public function insert_red_crescent_purchased($name, $quantity, $date, $unit_quantity, $unit_price)
    {
        $sql = "INSERT INTO `red_crescent`(`name`, `quantity`, `date`, `unit_quantity`,`type`, `unit_price`) VALUES ('$name','$quantity','$date', '$unit_quantity', 'purchased', '$unit_price')";
       
        return $this->execute($sql);
    }

    public function insert_donated_red_crescent_given($name, $quantity, $date, $unit_quantity, $unit_price, $step)
    {
        $sql = "INSERT INTO `red_crescent`(`name`, `quantity`, `date`, `type`, `unit_quantity`, `unit_price`, `step`) VALUES ('$name','$quantity','$date','given', '$unit_quantity', '$unit_price', '$step')";

        return $this->execute($sql);
    }

    public function select_red_crescent_purchased()
    {
        $sql = "SELECT * FROM red_crescent WHERE type='purchased'";

        return $this->fetchResult($sql);
    }

    public function select_red_crescent_given()
    {
        $sql = "SELECT * FROM red_crescent WHERE type='given'";

        return $this->fetchResult($sql);
    }

    public function select_donated_red_crescent_given()
    {
        $sql = "SELECT * FROM red_crescent WHERE type='given' and unit_price=0";

        return $this->fetchResult($sql);
    }

    public function select_red_crescent_purchased_date_report($from_date, $to_date)
    {
        $sql = "SELECT sum(quantity) as 'quantity' FROM `red_crescent` WHERE (date BETWEEN '$from_date' AND '$to_date') AND type='red_crescent'";

        return $this->fetchResult($sql);
    }

    public function select_red_crescent_given_date_report($from_date, $to_date)
    {
        $sql = "SELECT sum(quantity) as 'quantity' FROM `red_crescent` WHERE (date BETWEEN '$from_date' AND '$to_date') AND type='given'";

        return $this->fetchResult($sql);
    }
    public function select_red_crescent_given_date_report_stepped($from_date, $to_date, $step)
    {
        $sql = "SELECT sum(quantity) as 'quantity' FROM `red_crescent` WHERE (date BETWEEN '$from_date' AND '$to_date') AND type='given' AND step='$step'";

        return $this->fetchResult($sql);
    }

    public function select_red_crescent_items()
    {
        $sql = "SELECT distinct(name), unit_quantity FROM red_crescent";

        return $this->fetchResult($sql);
    }

    public function select_red_cresecnt_puchased_item_date_report($name, $from_date, $to_date)
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM `red_crescent` WHERE (name = '$name' ) AND (date BETWEEN '$from_date' AND '$to_date') AND type='purchased'";
      
        return $this->fetchResult($sql);
    }

    public function select_red_cresecnt_puchased_item_date_report_stepped($name, $from_date, $to_date, $step)
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM `red_crescent` WHERE (name = '$name' ) AND (date BETWEEN '$from_date' AND '$to_date') AND type='purchased' AND step='$step'";
      
        return $this->fetchResult($sql);
    }

    public function select_red_cresecnt_given_item_date_report($name, $from_date, $to_date)
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM `red_crescent` WHERE (name = '$name' ) AND (date BETWEEN '$from_date' AND '$to_date') AND type='given'";
        
        return $this->fetchResult($sql);
        
    }

    public function select_red_cresecnt_given_item_date_report_stepped($name, $from_date, $to_date, $step)
    {
        $sql = "SELECT SUM(quantity) as 'quantity' FROM `red_crescent` WHERE (name = '$name' ) AND (date BETWEEN '$from_date' AND '$to_date') AND type='given' AND step='$step'";
        
        return $this->fetchResult($sql);
        
    }

    public function select_red_crescent_purchased_item_quantiy($name)
    {
        $sql = "SELECT SUM(quantity) as quantity FROM `red_crescent` WHERE name = '$name' AND type='purchased'";

        return $this->fetchResult($sql);
    }
    public function select_red_crescent_given_item_quantiy($name)
    {
        $sql = "SELECT SUM(quantity) as quantity FROM `red_crescent` WHERE name = '$name' AND type='given'";

        return $this->fetchResult($sql);
    }


}