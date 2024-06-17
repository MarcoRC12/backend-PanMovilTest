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

        stage('Ejecutar php'){
            steps {
                sh 'php index.php'
            }
        }

        
         //Revisa la calidad de código con SonarQube
        //stage ('Sonarqube') {
         //   steps {
          //      script {
           //         def scannerHome = tool name: 'sonarscanner', type: 'hudson.plugins.sonar.SonarRunnerInstallation';
            //        echo "scannerHome = $scannerHome ...."
             //       withSonarQubeEnv() {
              //          sh "$scannerHome/bin/sonar-scanner"
               //     }
              //  }
           // }
       // }

         stage('Docker Build') {
            steps {
                sh 'docker build -t backend-panmovil .'
            }
        }
    }
}
