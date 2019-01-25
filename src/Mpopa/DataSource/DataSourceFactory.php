<?php
namespace Mpopa\DataSource;

/**
 * Returns a datasource object for handling the data access for Customers and Products.
 * All datasource classes must implement the DataSourceInterface interface.
 * The change of the datasource is transparent for the other classes.
 * See config.php for more details on how to change the datasource
 */
class DataSourceFactory
{
    public static function build($config)
    {
        switch ($config->datasource ?? null) {
            case 'mysql':
                return new MySQL($config);
                break;
            case 'json':
                return new Json($config);
                break;
            default:
                throw new \Mpopa\ExpException("Invalid datasource type. Check config.php file.");
                break;
        }

    }
}
