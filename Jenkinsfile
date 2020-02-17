node {
    def app

    stage('Clone repository'){
        checkout([$class: 'GitSCM', branches: [[name: '*/master']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[url: 'https://github.com/vsjadeja/prac1']]])
    }

    stage('Build image'){
        app = docker.build("vjadeja/test")
    }

    stage('Test image'){
        app.inside {
            echo "Test passed";
        }
    }

    stage('Push image'){
        docker.withRegistry('https://registry.hub.docker.com','docker-login'){
            app.push("${env.BUILD_NUMBER}")
        }
        echo "Trying to push docker build to docker hub"
    }
}