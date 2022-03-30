<?php
	
	require_once "mainModel.php";

	class usuarioModelo extends mainModel{

		/*--------- Modelo agregar usuario ---------*/
		protected static function agregar_usuario_modelo($datos){
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

		/*--------- Modelo eliminar usuario ---------*/
		protected static function eliminar_usuario_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblusuario WHERE usuario_id=:ID");

			$sql->bindParam(":ID", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS USUARIO */
		protected static function datos_usuario_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblusuario WHERE usuario_id=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT usuario_id FROM tblusuario WHERE usuario_id!='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR USUARIO */
		protected static function actualizar_usuario_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblusuario SET usuario_dni=:DNI, usuario_nombre=:Nombre,usuario_apellido=:Apellido, usuario_telefono=:Telefono, usuario_cargo=:Cargo, usuario_email=:Email, usuario_usuario=:Usuario, usuario_clave=:Clave, usuario_estado=:Estado, usuario_privilegio=:Privilegio WHERE usuario_id=:ID ");

			$sql->bindParam(":DNI", $datos['DNI']);
			$sql->bindParam(":Nombre", $datos['Nombre']);
			$sql->bindParam(":Apellido", $datos['Apellido']);
			$sql->bindParam(":Cargo", $datos['Cargo']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Telefono", $datos['Telefono']);
			$sql->bindParam(":Usuario", $datos['Usuario']);
			$sql->bindParam(":Clave", $datos['Clave']);
			$sql->bindParam(":Estado", $datos['Estado']);
			$sql->bindParam(":Privilegio", $datos['Privilegio']);
			$sql->bindParam(":ID", $datos['ID']);

			$sql->execute();
			return $sql;


		}

		protected static function actualizar_perfil_usuario_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblusuario SET usuario_dni=:DNI, usuario_nombre=:Nombre,usuario_apellido=:Apellido, usuario_telefono=:Telefono,  usuario_email=:Email, usuario_usuario=:Usuario, usuario_clave=:Clave WHERE usuario_id=:ID ");

			$sql->bindParam(":DNI", $datos['DNI']);
			$sql->bindParam(":Nombre", $datos['Nombre']);
			$sql->bindParam(":Apellido", $datos['Apellido']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Telefono", $datos['Telefono']);
			$sql->bindParam(":Usuario", $datos['Usuario']);
			$sql->bindParam(":Clave", $datos['Clave']);
			$sql->bindParam(":ID", $datos['ID']);

			$sql->execute();
			return $sql;
	}

}