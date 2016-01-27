<?php

namespace Base;

use \RunLog as ChildRunLog;
use \RunLogQuery as ChildRunLogQuery;
use \Exception;
use Map\RunLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'run_log' table.
 *
 *
 *
 * @method     ChildRunLogQuery orderByRuntime($order = Criteria::ASC) Order by the runtime column
 *
 * @method     ChildRunLogQuery groupByRuntime() Group by the runtime column
 *
 * @method     ChildRunLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRunLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRunLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRunLogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRunLogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRunLogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRunLog findOne(ConnectionInterface $con = null) Return the first ChildRunLog matching the query
 * @method     ChildRunLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRunLog matching the query, or a new ChildRunLog object populated from the query conditions when no match is found
 *
 * @method     ChildRunLog findOneByRuntime(string $runtime) Return the first ChildRunLog filtered by the runtime column *

 * @method     ChildRunLog requirePk($key, ConnectionInterface $con = null) Return the ChildRunLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRunLog requireOne(ConnectionInterface $con = null) Return the first ChildRunLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRunLog requireOneByRuntime(string $runtime) Return the first ChildRunLog filtered by the runtime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRunLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRunLog objects based on current ModelCriteria
 * @method     ChildRunLog[]|ObjectCollection findByRuntime(string $runtime) Return ChildRunLog objects filtered by the runtime column
 * @method     ChildRunLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RunLogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RunLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'ck-order-xml', $modelName = '\\RunLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRunLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRunLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRunLogQuery) {
            return $criteria;
        }
        $query = new ChildRunLogQuery();
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
     * @return ChildRunLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The RunLog object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The RunLog object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildRunLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The RunLog object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRunLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The RunLog object has no primary key');
    }

    /**
     * Filter the query on the runtime column
     *
     * Example usage:
     * <code>
     * $query->filterByRuntime('2011-03-14'); // WHERE runtime = '2011-03-14'
     * $query->filterByRuntime('now'); // WHERE runtime = '2011-03-14'
     * $query->filterByRuntime(array('max' => 'yesterday')); // WHERE runtime > '2011-03-13'
     * </code>
     *
     * @param     mixed $runtime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRunLogQuery The current query, for fluid interface
     */
    public function filterByRuntime($runtime = null, $comparison = null)
    {
        if (is_array($runtime)) {
            $useMinMax = false;
            if (isset($runtime['min'])) {
                $this->addUsingAlias(RunLogTableMap::COL_RUNTIME, $runtime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($runtime['max'])) {
                $this->addUsingAlias(RunLogTableMap::COL_RUNTIME, $runtime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RunLogTableMap::COL_RUNTIME, $runtime, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRunLog $runLog Object to remove from the list of results
     *
     * @return $this|ChildRunLogQuery The current query, for fluid interface
     */
    public function prune($runLog = null)
    {
        if ($runLog) {
            throw new LogicException('RunLog object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the run_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RunLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RunLogTableMap::clearInstancePool();
            RunLogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RunLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RunLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RunLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RunLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RunLogQuery
