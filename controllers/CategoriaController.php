<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\Categoria;

class CategoriaController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'only' => ['create', 'update', 'delete', 'search'],
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $draw = intval($request->get('draw'));
        $start = intval($request->get('start'));
        $length = intval($request->get('length'));
        $searchValue = $request->get('search')['value'] ?? null;
        $order = $request->get('order')[0] ?? null;

        $columns = ['id', 'nombre'];

        $query = Categoria::find();

        if ($searchValue) {
            $query->andWhere(['like', 'nombre', $searchValue]);
        }

        if ($order) {
            $colIndex = intval($order['column']);
            $dir = $order['dir'] === 'asc' ? SORT_ASC : SORT_DESC;
            if (isset($columns[$colIndex])) {
                $query->orderBy([$columns[$colIndex] => $dir]);
            }
        } else {
            $query->orderBy(['id' => SORT_ASC]);
        }

        $totalRecords = Categoria::find()->count();
        $filteredRecords = $query->count();

        $data = $query->offset($start)->limit($length)->asArray()->all();

        return [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data,
        ];
    }

    public function actionCreate()
    {
        $model = new Categoria();
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if ($model->load($data, '') && $model->save()) {
            return ['mensaje' => 'Categoría creada'];
        }

        return ['error' => $model->getErrors()];
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if ($model->load($data, '') && $model->save()) {
            return ['mensaje' => 'Categoría actualizada'];
        }

        return ['error' => $model->getErrors()];
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return ['mensaje' => 'Categoría eliminada'];
    }

    public function actionCreateForm()
    {
        $model = new Categoria();
        return $this->renderPartial('create', ['model' => $model]);
    }

    public function actionUpdateForm($id)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('update', ['model' => $model]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    protected function findModel($id)
    {
        if (($model = Categoria::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Categoría no encontrada.');
    }
}
