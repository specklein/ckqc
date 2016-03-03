<?php

namespace SPE\Core;

class QCConfigKey {

  //reports
  const _REVENUE_DATEFORMAT_CONFIG_KEY='cklein.revenue.reports.dateformat';
  const _REVENUE_REPORT_CUTOFF_HOUR_CONFIG_KEY='cklein.revenue.reports.cutoff.hour';
  const _REVENUE_REPORT_SHIPMENT_GTIN_CONFIG_KEY='cklein.shipment.gtin';
  const _REVENUE_REPORT_FOLDER = 'cklein.revenue.reports.folder';
  const _REVENUE_REPORT_FILENAME_INFIX = 'cklein.revenue.reports.filename.infix';
  const _REVENUE_REPORT_FILENAME_EXT = 'cklein.revenue.reports.filename.ext';

  //ordersdb
  const _ORDERS_DB_TYPE_CONFIG_KEY='cklein.orders.db.type';
  const _ORDERS_DB_SERVER_CONFIG_KEY='cklein.orders.db.server';
  const _ORDERS_DB_NAME_CONFIG_KEY='cklein.orders.db.name';
  const _ORDERS_DB_USERNAME_CONFIG_KEY='cklein.orders.db.username';
  const _ORDERS_DB_PASSWORD_CONFIG_KEY='cklein.orders.db.password';
  const _ORDERS_DB_CHARSET_CONFIG_KEY='cklein.orders.db.charset';
  const _ORDERS_DB_PORT_CONFIG_KEY='cklein.orders.db.port';

  //credentials
  const _CK_CREDENTIALS_CONFIG_SECTION='calvinklein';


}
