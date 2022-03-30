<?php
	
	require_once "mainModel.php";

	class programaModelo extends mainModel{

		/*--------- Modelo agregar PROGRAMA ---------*/
		protected static function agregar_programa_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblprogramaformacion(ProCodigoPrograma,ProNombre) VALUES (:CodigoPrograma,:Nombre)");

			$sql->bindParam(":CodigoPrograma",$datos['CodigoPrograma']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->execute();

			return $sql;
		}

		/*--------- Modelo eliminar PROGRAMA ---------*/
		protected static function eliminar_programa_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblprogramaformacion WHERE ProCodigo=:ID");

			$sql->bindParam(":ID", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS INSTRUCTOR */
		protected static function datos_programa_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblprogramaformacion WHERE ProCodigo=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT ProCodigo FROM tblprogramaformacion WHERE ProCodigo!='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR INSTRUCTOR */
		protected static function actualizar_programa_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblprogramaformacion SET ProCodigoPrograma=:CodigoPrograma, ProNombre=:Nombre WHERE ProCodigo=:ID");

			$sql->bindParam(":CodigoPrograma", $datos['CodigoPrograma']);
			$sql->bindParam(":Nombre", $datos['Nombre']);
			$sql->bindParam(":ID", $datos['ID']);

			$sql->execute();
			return $sql;

	}

}