<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Login;

use SetBased\Abc\Abc;
use SetBased\Abc\C;

/**
 * Login requirement: Maximum number of failed login attempts cause by a wrong password.
 */
class WrongPasswordCountLoginRequirement implements LoginRequirement
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The length of the interval in minutes.
   *
   * @var int
   */
  private $interval;

  /**
   * The ID of the login response for to many wrong passwords.
   *
   * @var int
   */
  private $lgrIdToManyWrongPassword;

  /**
   * The ID of the login response for a wrong password.
   *
   * @var int
   */
  private $lgrIdWrongPassword;

  /**
   * The maximum number of allowed failed login attempts due to a wrong password.
   *
   * @var int
   */
  private $maxFailedAttempts;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * WrongPasswordCountLoginRequirement constructor.
   *
   * @param int $lgrIdWrongPassword       The ID of the login response for a wrong password.
   * @param int $lgrIdToManyWrongPassword The ID of the login response for to many wrong passwords.
   * @param int $maxFailedAttempts        The maximum number of allowed failed login attempts due to a wrong password.
   * @param int $minutes                  The length of the interval in minutes.
   *
   * @since 1.0.0
   * @api
   */
  public function __construct($lgrIdWrongPassword, $lgrIdToManyWrongPassword, $maxFailedAttempts, $minutes)
  {
    $this->lgrIdWrongPassword       = $lgrIdWrongPassword;
    $this->lgrIdToManyWrongPassword = $lgrIdToManyWrongPassword;
    $this->maxFailedAttempts        = $maxFailedAttempts;
    $this->interval                 = $minutes;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Validates the number of failed login attempts caused by a wrong password is within limits.
   *
   * @param array $data The data for validating the login requirement.
   *
   * @return int
   *
   * @since 1.0.0
   * @api
   */
  public function validate(&$data)
  {
    $count = Abc::$DL->abcLoginHandlerCoreWrongPasswordByUsrIdCount(Abc::$companyResolver->getCmpId(),
                                                                    $data['usr_id'],
                                                                    $this->lgrIdWrongPassword,
                                                                    $this->interval);

    return ($count<=$this->maxFailedAttempts) ? C::LGR_ID_GRANTED : $this->lgrIdToManyWrongPassword;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
