<?php


namespace App\Service;


use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class StatsService
{

    private $manager;
    private $productRepository;

    public function __construct(EntityManagerInterface $manager, ProductRepository $productRepository)
    {
        $this->manager = $manager;
        $this->productRepository = $productRepository;
    }

    public function getStats()
    {
        $productOutOfStock = $this->getProductOutOfStock();
        $currentMonthAmountSale = $this->getCurrentMonthAmountSale();
        $lastMonthAmountSale = $this->getLastMonthAmountSale();
        $lastMonthNumberOfSale = $this->getLastMonthNumberOfSale();
        $currentMonthNumberOfSale = $this->getCurrentMonthNumberOfSale();
        $currentWeekNumberOfSale = $this->getCurrentWeekNumberOfSale();
        $currentWeekAmountSale = $this->getCurrentWeekAmountSale();
        $currentDayNumberOfSale = $this->getCurrentDayNumberOfSale();
        $currentDayAmountSale = $this->getCurrentDayAmountSale();
        $lastDayNumberOfSale = $this->getLastDayNumberOfSale();
        $lastDayAmountSale = $this->getLastDayAmountSale();
        $totalProductInStock = $this->getTotalProductInStock();
        $productMostSale = $this->getProductMostSale();
        $totalSale = $this->getTotalSale();
        $totalEntry = $this->getTotalEntry();
        $totalOut = $this->getTotalOut();
        $totalInit = $this->getTotalInit();
        $currentMonthAmountCommand = $this->getCurrentMonthAmountCommand();
        $totalProductInStockValue = $this->getTotalProductInStockValue();
       /* $dailyAvgSale = $this->getDailySale();*/



        return compact(
            'productOutOfStock',
            'currentMonthAmountSale',
            'currentMonthNumberOfSale',
            'lastMonthAmountSale',
            'lastMonthNumberOfSale',
            'currentWeekAmountSale',
            'currentWeekNumberOfSale',
            'lastDayAmountSale',
            'lastDayNumberOfSale',
            'currentDayAmountSale',
            'currentDayNumberOfSale',
            'totalProductInStock',
            'productMostSale',
            'totalSale',
            'totalEntry',
            'totalOut',
            'totalInit',
            'currentMonthAmountCommand',
            'totalProductInStockValue'
            //'dailyAvgSale'
        );
    }

    public function getProductOutOfStock()
    {
        $products = $this->productRepository->findAll();
        $productsOutOfStock = [];
        foreach ($products as $product){
            if($product->getStockQte() < $product->getInitQte()){
                $productsOutOfStock[] = $product;
            }
        }

        return $productsOutOfStock;
    }

    public function getCurrentMonthAmountSale()
    {
        $startMonth = new \DateTime('first day of this month');
        $startMonth->setTime(0, 0, 0);
        $endMonth = new \DateTime('last day of this month');
        $endMonth->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT SUM(sl.qte*p.salePrice) as amount
            FROM App\Entity\Sale s 
            JOIN s.saleLines sl
            JOIN sl.product p
            WHERE s.createdAt between :startMonth and :endMonth'
        )
            ->setParameters(['startMonth'=>$startMonth, 'endMonth'=>$endMonth])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }


    public function getLastMonthAmountSale()
    {
        $startMonth = new \DateTime('first day of last month');
        $startMonth->setTime(0, 0, 0);
        $endMonth = new \DateTime('last day of last month');
        $endMonth->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT SUM(sl.qte*p.salePrice) as amount
            FROM App\Entity\Sale s 
            JOIN s.saleLines sl
            JOIN sl.product p
            WHERE s.createdAt between :startMonth and :endMonth'
        )
            ->setParameters(['startMonth'=>$startMonth, 'endMonth'=>$endMonth])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getCurrentDayAmountSale()
    {
        $start = new \DateTime('today');
        $end = new \DateTime('today');
        $end->setTime(23, 59, 59);
        $result = $this->manager->createQuery(
            'SELECT SUM(sl.qte*p.salePrice) as amount
            FROM App\Entity\Sale s 
            JOIN s.saleLines sl
            JOIN sl.product p
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getLastDayAmountSale()
    {
        $start = new \DateTime('yesterday');
        $end = new \DateTime('yesterday');
        $end->setTime(23, 59, 59);

        $result =  $this->manager->createQuery(
            'SELECT SUM(sl.qte*p.salePrice) as amount
            FROM App\Entity\Sale s 
            JOIN s.saleLines sl
            JOIN sl.product p
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getCurrentWeekAmountSale(){
        $start = new \DateTime('this week');
        $start->modify('monday');
        $start->setTime(0, 0, 0);
        $end = new \DateTime('this week');
        $end->modify('sunday');
        $end->setTime(23, 59, 59);


        //dd($start, $end);

        $result = $this->manager->createQuery(
            'SELECT SUM(sl.qte*p.salePrice) as amount
            FROM App\Entity\Sale s 
            JOIN s.saleLines sl
            JOIN sl.product p
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getCurrentWeekNumberOfSale(){
        $start = new \DateTime('this week');
        $start->modify('monday');
        $start->setTime(0, 0, 0);
        $end = new \DateTime('this week');
        $end->modify('sunday');
        $end->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT count(s.id) as total
            FROM App\Entity\Sale s 
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getCurrentDayNumberOfSale(){
        $start = new \DateTime('today');
        $end = new \DateTime('today');
        $end->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT count(s.id) as amount
            FROM App\Entity\Sale s 
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getLastDayNumberOfSale(){
        $start = new \DateTime('last day');
        $end = new \DateTime('last day');
        $end->setTime(23, 59, 59);
        $result = $this->manager->createQuery(
            'SELECT count(s.id) as total
            FROM App\Entity\Sale s 
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    //Retourne le nombre de produit vendu dans le mois précédent
    public function getLastMonthNumberOfSale(){

        $start = new \DateTime('first day of last month');
        $start->setTime(0, 0, 0);
        $end = new \DateTime('last day of last month');
        $end->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT count(s.id) as total
            FROM App\Entity\Sale s 
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getCurrentMonthNumberOfSale(){

        $start = new \DateTime('first day of this month');
        $start->setTime(0, 0, 0);
        $end = new \DateTime('last day of this month');
        $end->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT count(s.id) as total
            FROM App\Entity\Sale s 
            WHERE s.createdAt between :start and :end'
        )
            ->setParameters(['start'=>$start, 'end'=>$end])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getTotalProductInStock(){
        $products = $this->productRepository->findAll();
        $productsInStock = 0;
        foreach ($products as $product){
            $productsInStock += $product->getStockQte();
        }

        return $productsInStock;
    }

    public function getTotalProductInStockValue(){
        $products = $this->productRepository->findAll();
        $productsInStockValue = 0;
        foreach ($products as $product){
            $productsInStockValue += $product->getStockValue();
        }

        return $productsInStockValue;
    }

    public function getProductMostSale(){
        return $this->manager->createQuery(
            'SELECT p.name, p.brandName, SUM(sl.qte) as totalSale,SUM(sl.qte*p.salePrice) as totalAmount, p.salePrice
            FROM App\Entity\Sale s 
            JOIN s.saleLines sl
            JOIN sl.product p
            GROUP BY p.name
            ORDER BY totalSale DESC'
        )
            ->setMaxResults(3)
            ->getResult();
    }

    public function getTotalSale()
    {
        $result = $this->manager->createQuery(
            'SELECT sum(sl.qte) as total
            FROM App\Entity\Sale s
            JOIN s.saleLines sl
            JOIN sl.product p'
        )
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getTotalEntry()
    {
        $result = $this->manager->createQuery(
            'SELECT sum(el.qte) as total
            FROM App\Entity\EntryInventory e
            JOIN e.entryInventoryLines el
            JOIN el.product p'
        )
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getTotalInit()
    {
        $result = $this->manager->createQuery(
            'SELECT sum(p.initQte) as total
            FROM App\Entity\Product p'
        )
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getTotalOut()
    {
        $result = $this->manager->createQuery(
            'SELECT sum(ol.qte) as total
            FROM App\Entity\OutInventory o
            JOIN o.outInventoryLines ol
            JOIN ol.product p'
        )
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    public function getCurrentMonthAmountCommand()
    {
        $startMonth = new \DateTime('first day of this month');
        $startMonth->setTime(0, 0, 0);
        $endMonth = new \DateTime('last day of this month');
        $endMonth->setTime(23, 59, 59);

        $result = $this->manager->createQuery(
            'SELECT SUM(ol.qte*ol.purchasePrice) as amount
            FROM App\Entity\Order o 
            JOIN o.orderLines ol
            JOIN ol.product p
            WHERE o.createdAt between :startMonth and :endMonth'
        )
            ->setParameters(['startMonth'=>$startMonth, 'endMonth'=>$endMonth])
            ->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }
    }

    /*public function getDailySale()
    {
        $result = $this->manager->createQuery(
            'SELECT DATE(s.saleAt) as jour, count(s.id) as dailySale
            FROM App\Entity\Sale s
            GROUP BY jour'
        )->getResult();
        return $result;
    }*/

    public function getDailyAverageSale()
    {
        /*$result = $this->manager->createQuery(
            'SELECT AVG(dailySale) as avgSale
            FROM (
            SELECT DATE(s.saleAt) as jour, count(s.id) as dailySale
            FROM App\Entity\Sale s
            GROUP BY jour
            )'
        )->getSingleScalarResult();

        if($result !== null ){
            return $result;
        }else{
            return 0;
        }*/
    }

}
