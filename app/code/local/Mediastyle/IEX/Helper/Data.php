<?php

class Mediastyle_IEX_Helper_Data extends Mage_Core_Helper_Abstract
{
  public function importProduct($product_data){
    $product =
      Mage::getModel('catalog/product')->load($product_data['Number']);

    $product->setWebsiteIds(array(1));
    $product->setAttributeSetId(4);
    $product->setSku($product_data['Number']);
    $product->setName($product_data['Name']);
    $product->setDescription($product_data['Description']);
    $product->setShortDescription($product_data['Description']);
    $product->setTypeId('simple');
    $product->setWeight(0);
    $product->setCategoryIds(array($product_data['ProductGroup']));
    $product->setPrice($product_data['SalesPrice']);
    $product->setCost($product_data['CostPrice']);
    $product->setTaxClassId('2');
    $product->setStatus(1);
    $product->setCreatedAt(strtotime('now'));

    $product->save();
  }

  protected function getProduct($product){
    $row['sku'] = $product->getSku();
    $row['title'] = $product->getName();
    $row['category'] = array_shift($product->getCategoryIds());
    $row['description'] = $product->getDescription();
    $row['units'] = 'stk.'; //not implemented
    $row['price'] = $product->getFinalPrice();
    return $row;
  }

  public function exportProducts(){
    $data = array();
    $products = Mage::getModel('catalog/product')->getCollection();
    foreach($products as $product){
      $data[] = $this->getProduct($product->load());
    }
    return $data;
  }

  protected function getCustomer($customer){
    $ids = $customer->getPrimaryAddressIds();
    $address = Mage::getModel('customer/address')->load(array_shift($ids));
    $row['id'] = $customer['entity_id'];
    $row['company'] = '';
    $row['lastname'] = $customer->getLastname();
    $row['firstname'] = $customer->getFirstname();
    $row['middlename'] = $customer->getMiddlename();
    $row['phone'] = $address->getTelephone();
    $row['address1'] = $address->getStreet1();
    $row['address2'] = $address->getStreet2();
    $row['city'] = $address->getCity();
    $row['country'] = $address->getCountry();
    $row['postalcode'] = $address->getPostcode();
    $row['email'] = $customer->getEmail();

    return $row;
  }

  public function exportCustomers(){
    $data = array();
    $customers = Mage::getModel('customer/customer')->getCollection();
    foreach($customers as $customer){
      $data[] = $this->getCustomer($customer->load());
    }
    return $data;
  }

  protected function getOrder($order){
    $row['orderid'] = $order->getEntityId() ;
    $row['customerid'] = $order->getCustomerId();
    $row['number'] = '';
    $row['total'] = $order->getGrandTotal();
    $row['subtotal'] = $order->getSubtotal();
    $row['tax'] = $order->getTaxAmount();
    $row['shipping'] = $order->getShippingAmount();
    $row['shipping_tax'] = $order->getShippingTaxAmount();
    $row[] = '';
    $row['coupon_code'] = $order->getCouponCode();
    $row['discount'] = $order->getDiscountAmount();
    $row['currency'] = $order->getOrderCurrencyCode();
    $row['shipping_method'] = $order->getShippingMethod();
    $row['date'] = $order->getCreatedAt();
    $row[] = '';
    $customer =
    $this->getCustomer(Mage::getModel('customer/customer')->load($order->getCustomerId()));
    $row['phone'] = $customer['phone'];
    return $row;
  }

  protected function getItem($item){
    $row['orderid'] = $item->getOrderId();
    $row['sku'] = $item->getSku();
    $row['title'] = $item->getName();
    $row['quantity'] = $item->getQtyToInvoice();
    $row['price'] = floatval($item->getPrice());
    $row['attribute'] = '';
    return $row;
  }

  public function exportOrders(){
    $data = array();
    $orders = Mage::getModel('sales/order')->getCollection();
    foreach($orders as $order){
      $loaded_order = $order->load();
      $data[] = $this->getOrder($loaded_order);
      $items = $loaded_order->getAllItems();
      foreach($items as $item){
        $data[] = $this->getItem($item);
      }
    }
    return $data;
  }
}
