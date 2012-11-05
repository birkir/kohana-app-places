<?php

class ISN93 {

	public function fx($p = 0)
	{
		return $this->a * cos($p/ $this->rho)/sqrt(1 - pow( $this->e * sin($p/ $this->rho), 2));
	}

	public function f1($p = 0)
	{
		return log((1 - $p)/(1 + $p));
	}

	public function f2($p = 0)
	{
		return $this->f1($p) - $this->e * $this->f1($this->e * $p);
	}

	public function f3($p = 0)
	{
		return $this->pol1 * exp(($this->f2(sin($p/ $this->rho)) - $this->f2sin1) * $this->sint / 2);
	}

	public function to_coords($xx = 0, $yy = 0)
	{
		$this->x = $xx;
		$this->y = $yy;

		$this->a = 6378137.0;
		$this->f = 1 / 298.257222101;

		$this->lat1 = 64.25;
		$this->lat2 = 65.75;
		$this->latc = 65.00;
		$this->lonc = 19.00;

		$this->eps = 0.00000000001;

		$this->rho = 45 / atan2(1.0, 1.0);
		$this->e = sqrt($this->f * (2 - $this->f));

		$this->dum = $this->f2(sin($this->lat1 / $this->rho)) - $this->f2(sin($this->lat2 / $this->rho));
		$this->sint = 2 * (log($this->fx($this->lat1)) - log($this->fx($this->lat2))) / $this->dum;

		$this->f2sin1 = $this->f2(sin($this->lat1 / $this->rho));
		$this->pol1 = $this->fx($this->lat1) / $this->sint;
		$this->polc = $this->f3($this->latc) + 500000.0;

		$this->peq = $this->a * cos($this->latc / $this->rho) / ($this->sint * exp($this->sint * log((45 - $this->latc / 2) / $this->rho)));

		$this->pol = sqrt(pow($this->x - 500000, 2) + pow($this->polc - $this->y, 2));

		$this->lat = 90 - 2 * $this->rho * atan(exp(log( $this->pol / $this->peq) / $this->sint));
		$this->lon = 0;

		$this->fact = $this->rho * cos($this->lat / $this->rho) / $this->sint / $this->pol;

		$this->delta = 1.0;

		while (abs($this->delta) > $this->eps)
		{
			 $this->delta = ($this->f3($this->lat) - $this->pol) * $this->fact;
			 $this->lat += $this->delta;
		}

		$this->lon = -($this->lonc + $this->rho * atan((500000 - $this->x) / ( $this->polc - $this->y) ) / $this->sint);

		return array(
			'latitude' => $this->lat,
			'longitude' => $this->lon
		);
	}
}