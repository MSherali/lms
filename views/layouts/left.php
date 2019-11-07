<?php
    $menu = [];
    $menu[] = ['label' => Yii::t('app','author'), 'icon' => 'user', 'url' => ['site/author']];
    $menu[] = ['label' => Yii::t('app','resource'), 'icon' => 'book', 'url' => ['resource/index']];
    if(!Yii::$app->user->isGuest)
    {
        if(Yii::$app->user->can('admin')){
            $menu[] = ['label' => Yii::t('app','courses'), 'icon' => 'graduation-cap', 'url' => ['courses/index']];
            $menu[] = ['label' => Yii::t('app','students'), 'icon' => 'user-circle', 'url' => ['users/index']];
            $menu[] = ['label' => Yii::t('app','articles'), 'icon' => 'book', 'url' => ['articles/index']];
            $menu[] = ['label' => Yii::t('app','questions'), 'icon' => 'calendar-check-o', 'url' => ['questions/index']];
            $menu[] = ['label' => Yii::t('app','test'), 'icon' => 'puzzle-piece', 'url' => ['/exams']];
            $menu[] = ['label' => Yii::t('app','essies'), 'icon' => 'question', 'url' => ['/essy']];
            $menu[] = ['label' => Yii::t('app','tasks'), 'icon' => 'tasks', 'url' => ['/task']];
            $menu[] = ['label' => Yii::t('app','register'), 'icon' => 'table', 'url' => ['/register']];
            $menu[] = ['label' => Yii::t('app','subjects'), 'icon' => 'cube', 'url' => ['/subjects']];
            $menu[] = ['label' => Yii::t('app','kafedras'), 'icon' => 'university', 'url' => ['/kafedras']];
        }
		else{
            $kafedras = \app\models\Kafedra::find()->with(['subjects.articles'=>function($q){ $q->orderBy('articles.sequence'); }])->where(['status'=>\app\models\Kafedra::STATUS_ACTIVE])->all();

            foreach ($kafedras as $kafedra){
                $sub_menu = [];
                foreach ($kafedra->subjects as $subject){
                    $sub_menu_items = [];
                    if($subject->status == \app\models\Subject::STATUS_ACTIVE){
                        foreach ($subject->articles as $article){
                            if($article->lang == Yii::$app->language && $article->course_id==Yii::$app->user->identity->course_id)
                                $sub_menu_items[] = ['label'=>$article->title, 'icon' => 'file-text', 'url' => ['articles/view','id'=>$article->id]];
                        }
                        if(count($sub_menu_items)>0) $sub_menu[] = ['label'=>$subject->short_name, 'icon' => 'circle-o', 'url' => '#', 'items'=>$sub_menu_items];
                    }
                }
                if(count($sub_menu)>0){
                    $menu[] = ['label'=>$kafedra->short_name, 'options' => ['class' => 'header']];
                    $menu = array_merge($menu, $sub_menu);
                }
            }

		}
    }

    


?>
<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menu,
            ]
        ) ?>

    </section>

</aside>
