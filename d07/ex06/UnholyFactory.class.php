<?php
class UnholyFactory {
	private $types = [];

	function absorb($type) {
		if ($type instanceof Fighter) {
			if (in_array($type, $this->types))
				echo "(Factory already absorbed a fighter of type " . $type->getType() . ")" . "\n";
			else {
				echo "(Factory absorbed a fighter of type " . $type->getType() . ")" . "\n";
				$this->types[] =  $type;
			}
		} else
			print("(Factory can't absorb this, it's not a fighter)" . "\n");
	}
    
	function fabricate($type) {
		$match = [
			"foot soldier" => "Footsoldier",
			"llama" => "Llama",
			"archer" => "Archer",
			"assassin" => "Assassin",
		];
		$class_type = $match[$type];
		foreach ($this->types as $value) {
			if (get_class($value) === $class_type) {
				echo "(Factory fabricates a fighter of type " . $type . ")". "\n";
				return ($value);
			}
		}
		echo "(Factory hasn't absorbed any fighter of type ". $type . ")". "\n";
	}
}
?>