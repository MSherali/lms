<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'fullname' => $this->string(100),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'status' => 'tinyint NOT NULL DEFAULT 10',

            'gruppa' => $this->string(50),
            'address' => $this->string(255),
            'birthplace' => $this->string(255),
            'phone' => $this->string(255),

            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        // seed admin
        $this->insert('users',[
            'username'=>'admin',
            'fullname'=>'Администратор',
            'email'=>'admin@ioncolog@uz',
            'password_hash'=>Yii::$app->security->generatePasswordHash('admin'),
            'auth_key'=>Yii::$app->security->generateRandomKey(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // seed RBAC
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $passTest = $auth->createPermission('pass-test');
        $passTest->description = 'Pass test';
        $auth->add($passTest);

        $student = $auth->createRole('student');
        $student->description = 'Student';
        $auth->add($student);
        $auth->addChild($student, $passTest);

        // admin related roles
        $manageArticles = $auth->createPermission('manage-articles');
        $manageArticles->description = 'Manage articles';
        $auth->add($manageArticles);

        $manageUsers = $auth->createPermission('manage-users');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        $manageQuestions = $auth->createPermission('manage-questions');
        $manageQuestions->description = 'Manage questions';
        $auth->add($manageQuestions);

        $manageAnswers = $auth->createPermission('manage-answers');
        $manageAnswers->description = 'Manage answers';
        $auth->add($manageAnswers);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $manageArticles);
        $auth->addChild($admin, $manageQuestions);
        $auth->addChild($admin, $manageAnswers);
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
        Yii::$app->authManager->removeAll();
    }
}
