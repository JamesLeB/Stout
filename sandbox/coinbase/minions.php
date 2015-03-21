<?php
class minions
{
	private $x;

	public function __construct()
	{
	}
	public function loadMinions()
	{
		$_SESSION['minions'] = [];
		for($i=1;$i<4;$i++)
		{
			$minion = array(
				'id'      => $i,
				'size'    => .01,
				'cost'    => 0.00,
				'price'   => 0.00,
				'orderId' => '0f',
				'state'   => 'Idle',
				'msg'     => 'Hmm'
			);
			$_SESSION['minions'][] = $minion;
		}
	}
	public function activateMinion($minionId)
	{
		if($_SESSION['minions'][$minionId-1]['state'] == 'Idle')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Bid';
		}
		else if($_SESSION['minions'][$minionId-1]['state'] == 'Bid')
		{
			$_SESSION['minions'][$minionId-1]['state'] = 'Idle';
		}
	}
	public function act()
	{
		foreach($_SESSION['minions'] as $minion)
		{
			if($minion['state'] == 'Idle')
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Waiting';
			}
			else if($minion['state'] == 'Bid')
			{
				# GET HIGH BID
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Getting high bid';

				$keys = array_keys($_SESSION['bookBids']);
				usort($keys);

				$_SESSION['minions'][$minion['id']-1]['cost'] = array_shift($keys) + 0;

			}
			else
			{
				$_SESSION['minions'][$minion['id']-1]['msg'] = 'Post Bid';
			}
		}
	}
}
?>
