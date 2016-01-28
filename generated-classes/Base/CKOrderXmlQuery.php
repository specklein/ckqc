<?php

namespace Base;

use \CKOrderXml as ChildCKOrderXml;
use \CKOrderXmlQuery as ChildCKOrderXmlQuery;
use \Exception;
use \PDO;
use Map\CKOrderXmlTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cklien_order_xml' table.
 *
 *
 *
 * @method     ChildCKOrderXmlQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCKOrderXmlQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method     ChildCKOrderXmlQuery orderByOrderXml($order = Criteria::ASC) Order by the order_xml column
 * @method     ChildCKOrderXmlQuery orderByOrderDate($order = Criteria::ASC) Order by the order_date column
 * @method     ChildCKOrderXmlQuery orderByXmlFilename($order = Criteria::ASC) Order by the xml_filename column
 * @method     ChildCKOrderXmlQuery orderByXmlFilesize($order = Criteria::ASC) Order by the xml_filesize column
 * @method     ChildCKOrderXmlQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildCKOrderXmlQuery groupById() Group by the id column
 * @method     ChildCKOrderXmlQuery groupByOrderId() Group by the order_id column
 * @method     ChildCKOrderXmlQuery groupByOrderXml() Group by the order_xml column
 * @method     ChildCKOrderXmlQuery groupByOrderDate() Group by the order_date column
 * @method     ChildCKOrderXmlQuery groupByXmlFilename() Group by the xml_filename column
 * @method     ChildCKOrderXmlQuery groupByXmlFilesize() Group by the xml_filesize column
 * @method     ChildCKOrderXmlQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildCKOrderXmlQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCKOrderXmlQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCKOrderXmlQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCKOrderXmlQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCKOrderXmlQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCKOrderXmlQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCKOrderXml findOne(ConnectionInterface $con = null) Return the first ChildCKOrderXml matching the query
 * @method     ChildCKOrderXml findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCKOrderXml matching the query, or a new ChildCKOrderXml object populated from the query conditions when no match is found
 *
 * @method     ChildCKOrderXml findOneById(int $id) Return the first ChildCKOrderXml filtered by the id column
 * @method     ChildCKOrderXml findOneByOrderId(string $order_id) Return the first ChildCKOrderXml filtered by the order_id column
 * @method     ChildCKOrderXml findOneByOrderXml(string $order_xml) Return the first ChildCKOrderXml filtered by the order_xml column
 * @method     ChildCKOrderXml findOneByOrderDate(string $order_date) Return the first ChildCKOrderXml filtered by the order_date column
 * @method     ChildCKOrderXml findOneByXmlFilename(string $xml_filename) Return the first ChildCKOrderXml filtered by the xml_filename column
 * @method     ChildCKOrderXml findOneByXmlFilesize(int $xml_filesize) Return the first ChildCKOrderXml filtered by the xml_filesize column
 * @method     ChildCKOrderXml findOneByCreatedAt(string $created_at) Return the first ChildCKOrderXml filtered by the created_at column *

 * @method     ChildCKOrderXml requirePk($key, ConnectionInterface $con = null) Return the ChildCKOrderXml by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOne(ConnectionInterface $con = null) Return the first ChildCKOrderXml matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCKOrderXml requireOneById(int $id) Return the first ChildCKOrderXml filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOneByOrderId(string $order_id) Return the first ChildCKOrderXml filtered by the order_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOneByOrderXml(string $order_xml) Return the first ChildCKOrderXml filtered by the order_xml column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOneByOrderDate(string $order_date) Return the first ChildCKOrderXml filtered by the order_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOneByXmlFilename(string $xml_filename) Return the first ChildCKOrderXml filtered by the xml_filename column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOneByXmlFilesize(int $xml_filesize) Return the first ChildCKOrderXml filtered by the xml_filesize column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCKOrderXml requireOneByCreatedAt(string $created_at) Return the first ChildCKOrderXml filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCKOrderXml[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCKOrderXml objects based on current ModelCriteria
 * @method     ChildCKOrderXml[]|ObjectCollection findById(int $id) Return ChildCKOrderXml objects filtered by the id column
 * @method     ChildCKOrderXml[]|ObjectCollection findByOrderId(string $order_id) Return ChildCKOrderXml objects filtered by the order_id column
 * @method     ChildCKOrderXml[]|ObjectCollection findByOrderXml(string $order_xml) Return ChildCKOrderXml objects filtered by the order_xml column
 * @method     ChildCKOrderXml[]|ObjectCollection findByOrderDate(string $order_date) Return ChildCKOrderXml objects filtered by the order_date column
 * @method     ChildCKOrderXml[]|ObjectCollection findByXmlFilename(string $xml_filename) Return ChildCKOrderXml objects filtered by the xml_filename column
 * @method     ChildCKOrderXml[]|ObjectCollection findByXmlFilesize(int $xml_filesize) Return ChildCKOrderXml objects filtered by the xml_filesize column
 * @method     ChildCKOrderXml[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildCKOrderXml objects filtered by the created_at column
 * @method     ChildCKOrderXml[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CKOrderXmlQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CKOrderXmlQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ck-order-xml', $modelName = '\\CKOrderXml', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCKOrderXmlQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCKOrderXmlQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCKOrderXmlQuery) {
            return $criteria;
        }
        $query = new ChildCKOrderXmlQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCKOrderXml|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CKOrderXmlTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CKOrderXmlTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCKOrderXml A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, order_id, order_xml, order_date, xml_filename, xml_filesize, created_at FROM cklien_order_xml WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCKOrderXml $obj */
            $obj = new ChildCKOrderXml();
            $obj->hydrate($row);
            CKOrderXmlTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildCKOrderXml|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId('fooValue');   // WHERE order_id = 'fooValue'
     * $query->filterByOrderId('%fooValue%'); // WHERE order_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderId)) {
                $orderId = str_replace('*', '%', $orderId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the order_xml column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderXml('fooValue');   // WHERE order_xml = 'fooValue'
     * $query->filterByOrderXml('%fooValue%'); // WHERE order_xml LIKE '%fooValue%'
     * </code>
     *
     * @param     string $orderXml The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByOrderXml($orderXml = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($orderXml)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $orderXml)) {
                $orderXml = str_replace('*', '%', $orderXml);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_ORDER_XML, $orderXml, $comparison);
    }

    /**
     * Filter the query on the order_date column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderDate('2011-03-14'); // WHERE order_date = '2011-03-14'
     * $query->filterByOrderDate('now'); // WHERE order_date = '2011-03-14'
     * $query->filterByOrderDate(array('max' => 'yesterday')); // WHERE order_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $orderDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByOrderDate($orderDate = null, $comparison = null)
    {
        if (is_array($orderDate)) {
            $useMinMax = false;
            if (isset($orderDate['min'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_ORDER_DATE, $orderDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderDate['max'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_ORDER_DATE, $orderDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_ORDER_DATE, $orderDate, $comparison);
    }

    /**
     * Filter the query on the xml_filename column
     *
     * Example usage:
     * <code>
     * $query->filterByXmlFilename('fooValue');   // WHERE xml_filename = 'fooValue'
     * $query->filterByXmlFilename('%fooValue%'); // WHERE xml_filename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $xmlFilename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByXmlFilename($xmlFilename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($xmlFilename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $xmlFilename)) {
                $xmlFilename = str_replace('*', '%', $xmlFilename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_XML_FILENAME, $xmlFilename, $comparison);
    }

    /**
     * Filter the query on the xml_filesize column
     *
     * Example usage:
     * <code>
     * $query->filterByXmlFilesize(1234); // WHERE xml_filesize = 1234
     * $query->filterByXmlFilesize(array(12, 34)); // WHERE xml_filesize IN (12, 34)
     * $query->filterByXmlFilesize(array('min' => 12)); // WHERE xml_filesize > 12
     * </code>
     *
     * @param     mixed $xmlFilesize The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByXmlFilesize($xmlFilesize = null, $comparison = null)
    {
        if (is_array($xmlFilesize)) {
            $useMinMax = false;
            if (isset($xmlFilesize['min'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_XML_FILESIZE, $xmlFilesize['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($xmlFilesize['max'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_XML_FILESIZE, $xmlFilesize['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_XML_FILESIZE, $xmlFilesize, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CKOrderXmlTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CKOrderXmlTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCKOrderXml $cKOrderXml Object to remove from the list of results
     *
     * @return $this|ChildCKOrderXmlQuery The current query, for fluid interface
     */
    public function prune($cKOrderXml = null)
    {
        if ($cKOrderXml) {
            $this->addUsingAlias(CKOrderXmlTableMap::COL_ID, $cKOrderXml->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cklien_order_xml table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CKOrderXmlTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CKOrderXmlTableMap::clearInstancePool();
            CKOrderXmlTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CKOrderXmlTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CKOrderXmlTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CKOrderXmlTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CKOrderXmlTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CKOrderXmlQuery
