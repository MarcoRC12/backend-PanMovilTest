pipeline {
    agent any

    stages {
        
        stage('Preparacion'){
            steps {
                git 'git@github.com:MarcoRC12/backend-PanMovilTest.git'
   	       		echo 'Pulled from github successfully'
            }
        }
        
        stage('Verifica version php'){
            steps {
                sh 'php --version'
            }
        }
         stage('Docker Build') {
            steps {
                sh 'docker build -t backend-panmovil .'
            }
         }
    }
}
