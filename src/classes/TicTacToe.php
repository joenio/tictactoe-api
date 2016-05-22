<?php
/**
 * @Entity @Table(name="tictactoes")
 **/
class TicTacToe {

  /** @Id @Column(type="integer") @GeneratedValue **/
  protected $id;

  private $token = null;
  public $grid = array(
    array(null, null, null),
    array(null, null, null),
    array(null, null, null)
  );

  public function __construct($token) {
    $this->token = $token;
  }

  public function mark($row, $column) {
    $this->grid[$row][$column] = 'X';
  }

}
?>
