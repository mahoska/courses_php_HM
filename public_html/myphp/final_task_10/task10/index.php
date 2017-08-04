<?php 
include('config.php');
include('libs/functions.php');
include('libs/Sql.php');

try {

$queries = [];
//*****testing query******
/*
SELECT product.id, product.name, producer.name, price, description
FROM product JOIN producer ON product.producer_id = producer.id
WHERE product.price >100
GROUP BY producer.name
HAVING producer.name LIKE '%OOO%'
ORDER BY price
LIMIT 5
 */

$sql = new Sql(PGSQL);
$res1 =  $sql->select(['product.id','product.name','producer.name', 'price', 'description'])->
    from('product')->join('producer', 'product.producer_id = producer.id')->
    where('product.price>100')->
    group(['producer.name'])->
    having("producer.name LIKE '%OOO%'")->
    order(['price'])->
    limit(5)->
    exec();

$sq =  $res1->getExecQuery();

$sql = new Sql(MYSQL);
$res2 = $sql->select(['product.id','product.name','producer.name', 'price', 'description'])->
    from('product')->join('producer', 'product.`producer_id` = producer.`id`')->
    where('product.`price`>100')->
    group(['producer.name'])->
    having("producer.`name` LIKE '%OOO%'")->
    order(['price'])->
    limit(5)->
    exec();

$pq = $res2->getExecQuery();

$sql = new Sql(PGSQL);
$errorQuery = $sql->select(['product.id','product.name','producer.name', 'price', 'description','name'])->
    from('product')->join('producer', 'product.producer_id = producer.id')->
    where('product.price>100')->
    group(['producer.name'])->
    having("producer.name LIKE '%OOO%'")->
    order(['price'])->
    limit(5)->
    exec();

$erq =  $errorQuery->getExecQuery();

$queries["select_1"] = ['mysql'=>$sq, 'pgsql'=>$pq, 'erq'=>$erq];
//echo "<pre>";
//var_dump($queries);
/*
SELECT Product.Name , Product.Price,  Category.Name 
FROM Category LEFT JOIN Product ON Category.IdCategory=Product.IdCategory
WHERE Category.Name='milk'
GROUP BY Product.Name,  Category.Name
ORDER BY  Product.Price DESC;
 */
$sql = new Sql(PGSQL);
$res = $sql->select(['product.name' , 'product.price' , 'category.name'])->
        from('category')->
        leftJoin('product', 'category.idCategory = product.idCategory')->
        where('category.Name="milk"')->
        group(['product.Name',  'category.Name'])->
        order(['product.Price'], false)->exec();

$pg = $res->getExecQuery();


$sql = new Sql(MYSQL);
$res = $sql->select(['product.name' , 'product.price' , 'category.name'])->
        from('category')->
        leftJoin('product', 'category.`idCategory` = product.`idCategory`')->
        where('category.Name="milk"')->
        group(['product.Name',  'category.Name'])->
        order(['product.Price'], false)->exec();

$sq = $res->getExecQuery();

$queries["select_2"] = ['mysql'=>$sq, 'pgsql'=>$pq];

/*
UPDATE Delivery SET Delivery.DataDelivery = DATE_ADD(NOW(), INTERVAL 14 DAY)
WHERE Delivery.DataDelivery IN (SELECT  Delivery.DataDelivery
FROM Product  JOIN Delivery ON Product.IdProduct=Delivery.IdProduct
WHERE Delivery.DataDelivery=[Дата поставки]);
 */

$sql = new Sql(PGSQL);
$sqlin = new Sql(PGSQL);

$inq = $sqlin->select(['delivery.dataDelivery'])->
        from('product')->
        join('delivery', 'product.idProduct=delivery.idProduct')->
        where('delivery.dataDelivery="2067-12-01"')->exec();
        
$inqs = $inq->getExecQuery();

$res = $sql->update()->
        from('delivery')->
        set(['Ddelivery.dataDelivery'=>'DATE_ADD(NOW(), INTERVAL 14 DAY)'])->
        where('delivery.dataDelivery IN ('.$inqs.')')->
        group(['product.Name',  'category.Name'])->
        order(['product.Price'], false)->exec();

$pq = $res->getExecQuery();


$sql = new Sql(MYSQL);
$sqlin = new Sql(MYSQL);

$inq = $sqlin->select(['delivery.dataDelivery'])->
        from('product')->
        join('delivery', 'product.`idProduct`=delivery.`idProduct`')->
        where('delivery.`dataDelivery`="2067-12-01"')->exec();
        
$inqs = $inq->getExecQuery();

$res = $sql->update()->
        from('delivery')->
        set(['ddelivery.dataDelivery'=>'DATE_ADD(NOW(), INTERVAL 14 DAY)'])->
        where('delivery.`dataDelivery` IN ('.$inqs.')')->
        group(['product.Name',  'category.Name'])->
        order(['product.Price'], false)->exec();

$sq = $res->getExecQuery();

$queries["update"] = ['mysql'=>$sq, 'pgsql'=>$pq];

/*
 DELETE *
FROM Sale
WHERE IdProduct IN (SELECT IdProduct
                    FROM Product  
                    WHERE IdCategory IN (SELECT IdCategory
                                            FROM Category
                                            WHERE Name='Кондитерські')
                    )
               AND (MONTHNAME(dateSale) = "November");
 */

$sql = new Sql(PGSQL);
$sqlin = new Sql(PGSQL);
$sqliin = new Sql(PGSQL);

$iinq = $sqliin->select(['idCategory'])->from('category')->where('name="confectionery"')->exec();
$iinqs = $iinq->getExecQuery();
$inq = $sqlin->select(['idProduct'])->from('product')->
        where('idCategory IN ('.$iinqs.')) AND (MONTHNAME(dateSale) = "November")')
        ->exec();
$inqs = $inq->getExecQuery();
$res = $sql->delete()->from('sale')->where('idProduct IN ('.$inqs.')')->exec();
$pq = $res->getExecQuery();

        
$sql = new Sql(MYSQL);
$sqlin = new Sql(MYSQL);
$sqliin = new Sql(MYSQL);

$iinq = $sqliin->select(['idCategory'])->from('category')->where('`name`="confectionery"')->exec();
$iinqs = $iinq->getExecQuery();
$inq = $sqlin->select(['idProduct'])->from('product')->
        where('`idCategory` IN ('.$iinqs.')) AND (MONTHNAME(`dateSale`) = "November")')
        ->exec();
$inqs = $inq->getExecQuery();
$res = $sql->delete()->from('sale')->where('`idProduct` IN ('.$inqs.')')->exec();
$sq = $res->getExecQuery();

$queries["delete"] = ['mysql'=>$sq, 'pgsql'=>$pq];


/*
INSERT INTO country ( name )
VALUES ('USA');
*/

$sql = new Sql(MYSQL);
$res = $sql->insert()->from('country')->setting(['name'=>'USA'])->exec();
$sq = $res->getExecQuery();

$sql = new Sql(PGSQL);
$res = $sql->insert()->from('country')->setting(['name'=>'USA'])->exec();
$pq = $res->getExecQuery();

$queries["insert"] = ['mysql'=>$sq, 'pgsql'=>$pq];

    
} catch (Exception $ex) {
    setFlash($ex->getMessage(),'fail');
}

$flashMessage = getFlash();  
include('templates/index.php');