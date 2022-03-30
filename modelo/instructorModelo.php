<?php
	
	require_once "mainModel.php";

	class instructorModelo extends mainModel{

		/*--------- Modelo agregar instructor ---------*/
		protected static function agregar_instructor_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblinstructor(InsIdentificacion,InsNombres,InsApellidos,InsEmail,InsTelefono) VALUES (:Identificacion,:Nombres,:Apellidos,:Email,:Telefono)");

			$sql->bindParam(":Identificacion",$datos['Identificacion']);
			$sql->bindParam(":Nombres",$datos['Nombres']);
			$sql->bindParam(":Apellidos",$datos['Apellidos']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Telefono",$datos['Telefono']);
			$sql->execute();

			return $sql;
		}

		/*--------- Modelo eliminar INSTRUCTOR ---------*/
		protected static function eliminar_instructor_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblinstructor WHERE InsId=:ID");

			$sql->bindParam(":ID", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS INSTRUCTOR */
		protected static function datos_instructor_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblinstructor WHERE InsId=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT InsId FROM tblinstructor WHERE InsId!='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR INSTRUCTOR */
		protected static function actualizar_instructor_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblinstructor SET InsIdentificacion=:DNI, InsNombres=:Nombre,InsApellidos=:Apellido, InsTelefono=:Telefono, InsEmail=:Email WHERE InsId=:ID ");

			$sql->bindParam(":DNI", $datos['DNI']);
			$sql->bindParam(":Nombre", $datos['Nombre']);
			$sql->bindParam(":Apellido", $datos['Apellido']);
			$sql->bindParam(":Email",$datos['Email']);
			$sql->bindParam(":Telefono", $datos['Telefono']);
			$sql->bindParam(":ID", $datos['ID']);

			$sql->execute();
			return $sql;

	}

}