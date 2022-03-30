<?php
	
	require_once "mainModel.php";

	class competenciaModelo extends mainModel{

		/*--------- Modelo agregar instructor ---------*/
		protected static function agregar_competencia_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblcompetencias(ComCodigoCompetencia,FkRelCompetencia_Programa,ComNombre) VALUES (:CodigoCompetencia,:RelCompetenciaPrograma,:Nombre)");

			$sql->bindParam(":CodigoCompetencia",$datos['CodigoCompetencia']);
			$sql->bindParam(":RelCompetenciaPrograma",$datos['RelCompetenciaPrograma']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->execute();

			return $sql;
		}

		/*--------- Modelo eliminar COMPETENCIA ---------*/
		protected static function eliminar_competencia_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblcompetencias WHERE ComCodigo=:ID");

			$sql->bindParam(":ID", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS COMPETENCIA */
		protected static function datos_competencia_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblcompetencias WHERE ComCodigo=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT ComCodigo FROM tblcompetencias WHERE ComCodigo!='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR COMPETENCIA */
		protected static function actualizar_competencia_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblcompetencias SET ComCodigoCompetencia=:CodigoCompetencia, ComNombre=:Nombre WHERE ComCodigo=:ID ");

			$sql->bindParam(":CodigoCompetencia", $datos['CodigoCompetencia']);
			$sql->bindParam(":Nombre", $datos['Nombre']);
			$sql->bindParam(":ID", $datos['ID']);

			$sql->execute();
			return $sql;

	}

}