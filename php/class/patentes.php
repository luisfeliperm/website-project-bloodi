<?php 
/**
 * 
 */
class Patentes
{
	public static function Name(Int $n) : String{
		$patente = array(
			'Novato',
			'Recruta',
			'Soldado',
			'Cabo',
			'Sargento',
			'Terceiro Sargento 1',
			'Terceiro Sargento 2',
			'Terceiro Sargento 3',
			'Segundo Sargento 1',
			'Segundo Sargento 2',
			'Segundo Sargento 3',
			'Segundo Sargento 4',
			'Primeiro Sargento 1',
			'Primeiro Sargento 2',
			'Primeiro Sargento 3',
			'Primeiro Sargento 4',
			'Primeiro Sargento 5',
			'Segundo Tenente 1',
			'Segundo Tenente 2',
			'Segundo Tenente 3',
			'Segundo Tenente 4',
			'Primeiro Tenente 1',
			'Primeiro Tenente 2',
			'Primeiro Tenente 3',
			'Primeiro Tenente 4',
			'Primeiro Tenente 5',
			'Capitão 1',
			'Capitão 2',
			'Capitão 3',
			'Capitão 4',
			'Capitão 5',
			'Major 1',
			'Major 2',
			'Major 3',
			'Major 4',
			'Major 5',
			'Tenente Coronel 1',
			'Tenente Coronel 2',
			'Tenente Coronel 3',
			'Tenente Coronel 4',
			'Tenente Coronel 5',
			'Coronel 1',
			'Coronel 2',
			'Coronel 3',
			'Coronel 4',
			'Coronel 5',
			'General de Brigada',
			'General de Divisão',
			'General de Exército',
			'Marechal',
			'Herói de Guerra',
			'Hero',
			53 => 'Game Master',
			54 => 'Moderador',
			55 => 'Admin',
			56 => 'Admin',
			57 => 'Admin',
			58 => 'Admin',
			59 => 'Admin'
		);
		if (!array_key_exists($n, $patente)) {
			return (String)$patente[0];
		}
		return (String)$patente[$n];
	}
}