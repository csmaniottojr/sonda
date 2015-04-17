<?php

namespace comunic\social_network_analyzer\model\repository\{
/**
 * class IUsersRepository
 *
 */
interface IUsersRepository
{

  /** Aggregations: */

  /** Compositions: */

  /**
   *
   *
   * @param  user
   * @return void
   * @access public
   */
  public function insert( $user);

  /**
   *
   *
   * @param  user
   * @return void
   * @access public
   */
  public function update( $user);

  /**
   *
   *
   * @param int id
   * @return void
   * @access public
   */
  public function delete( $id);

  /**
   *
   *
   * @param int id
   * @return void
   * @access public
   */
  public function findById( $id);

  /**
   *
   *
   * @return void
   * @access public
   */
  public function listAll();



}

} // end of IUserRepository
?>