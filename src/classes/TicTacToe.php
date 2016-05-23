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

  const INVALID_FIELD= 10;
  const FIELD_IN_USE= 20;

  public function __construct($token) {
    $this->token = $token;
  }

  public function is_valid_grid_index($row, $column) {
	  if($row > 2 || $column > 2 || $rown < 0 || $column < 0) {
	    return false;
	  }
	  else {
        return true;
	  }
  }

  public function mark($row, $column, $symbol) {
    $result;
    if($this->is_valid_grid_index($row,$column)) {
      if(is_null($this->grid[$row][$column])) {
        $this->grid[$row][$column] = $symbol;
        $result = "SUCCSESS";
      }
      else {
        $result = "POSITION ALREADY MARKED";
      }
    }
    else {
      $result = "INVALID FIELD POSITION";
    }
    return $result;
  }

  public function getGrid() {
    return $this->grid;
  }

  public function getWinner() {
    $grid = $this->getGrid();
    for ($row = 0; $row < 3; $row++) {
      $value = '';
      for ($column = 0; $column < 3; $column++) {
        if (! is_null($grid[$row][$column])) {
          $value = $value . $grid[$row][$column];
        }
      }
      if ($value == 'XXX') {
        return 'X';
      }
      elseif ($value == 'OOO') {
        return 'O';
      }
    }
    for ($column = 0; $column < 3; $column++) {
      $value = '';
      for ($row = 0; $row < 3; $row++) {
        $value = $value . $grid[$row][$column];
      }
      if ($value == 'XXX') {
        return 'X';
      }
      elseif ($value == 'OOO') {
        return 'O';
      }
    }
    $value = '';
    for ($i = 0; $i < 3; $i++) {
      $value = $value . $grid[$i][$i];
    }
    if ($value == 'XXX') {
      return 'X';
    }
    elseif ($value == 'OOO') {
      return 'O';
    }
    $value = '';
    for ($i = 0; $i < 3; $i++) {
      $value = $value . $grid[2-$i][$i];
    }
    if ($value == 'XXX') {
      return 'X';
    }
    elseif ($value == 'OOO') {
      return 'O';
    }
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
