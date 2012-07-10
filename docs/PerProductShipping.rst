========================================
Per Product Shipping plugin for Jigoshop
========================================

Installation
------------

* Assuming that ``Jigoshop`` is already installed and enabled.

* Unzip ``pp_shipping.zip`` and copy ``pp_shipping.php`` file to ``wp-content/plugins/jigoshop/shipping/`` folder.

* Enable and configure the ``Per Product Shipping`` method in Jigoshop shipping's config: ``http://<website url>/wp-admin/admin.php?page=settings``.

  .. image:: images/01_settings.png
      :align: center
      :width: 80%

Usage
-----

* Add a custom product attribute named ``Shipping Price`` to those products wanted to have custom shipping prices. By default 0.00 is assumed.

  .. image:: images/02_product_attributes.png
      :align: center
      :width: 80%
  
  .. note::
  
    The shipping calculation for each product will be done according the value of this custom field.

* The shipping calculation can be seen at the shopping cart:

  .. image:: images/03_cart.png
      :align: center
      :width: 60%

* And also in the Checkout page

  .. image:: images/04_checkout.png
      :align: center
      :width: 70%

.. note::

  Tested with the other shipping methods disabled.

