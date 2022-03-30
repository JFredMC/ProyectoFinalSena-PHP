<?php
	
	require_once "mainModel.php";

	class asignarModelo extends mainModel{

		/*--------- Modelo agregar usuario ---------*/
		protected static function asignar_usuario_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblusuario(usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_cargo,usuario_privilegio) VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Email,:Usuario,:Clave,:Estado,:Cargo,:Privilegio)");

			$sql->bindParam(":DNI",$datos['DNI']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Apellido",$datos['Apellido']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Usuario",$datos['Usuario']);
			$sql->bindParam(":Clave",$datos['Clave']);
			$sql->bindParam(":Estado",$datos['Estado']);
			$sql->bindParam(":Cargo",$datos['Cargo']);
			$sql->bindParam(":Privilegio",$datos['Privilegio']);

			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS USUARIO */
		protected static function datos_asignar_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblinstructor WHERE InsId=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT InsId FROM tblinstructor WHERE InsId!='1'");

			}
			$sql->execute();
			return $sql;
		}
	}

?>