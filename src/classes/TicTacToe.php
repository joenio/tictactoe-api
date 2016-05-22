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

  public function mark($row, $column, $symbol) {
    $this->grid[$row][$column] = $symbol;
  }

  public function getGrid() {
    return $this->grid;
  }

  public function getWinner() {
    # retorna o vencedor se houver algum ou falso caso contrário
    return false;
  }

  public function checkGridFulfilled() {
    $grid = $this->getGrid();
    for ($row = 0; $row < 3; $row++) {
      for ($column = 0; $column < 3; $column++) {
        if (is_null($grid[$row][$column])) {
          return true;
        }
      }
    }
    return false;
  }

  public function checkDraw() {
    $winner = $this->getWinner();
    $fulfilled = $this->checkGridFulfilled();
    return !$winner && $fulfilled;
  }

}
?>
