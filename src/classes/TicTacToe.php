<?php
/**
 * @Entity @Table(name="tictactoes")
 **/
class TicTacToe {

  /** @Id @Column(type="string") **/
  protected $token;

  /** @Column(type="array") **/
  protected $grid = array(
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

  public function getGrid() {
    return $this->grid;
  }

}
?>
