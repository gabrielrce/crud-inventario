<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\Producto;

class ProductoController extends Controller
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

    /**
     * Lista de productos con búsqueda opcional
     */
    public function actionSearch()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $draw = intval($request->get('draw'));
        $start = intval($request->get('start'));
        $length = intval($request->get('length'));

        $searchValue = $request->get('search')['value'] ?? null;
        $order = $request->get('order')[0] ?? null;

        $categoria_id = $request->get('categoria_id');
        $precio_min = $request->get('precio_min');
        $precio_max = $request->get('precio_max');

        $columns = ['id', 'nombre', 'descripcion', 'precio', 'stock', 'categoria_id'];

        $query = Producto::find();

        if ($searchValue) {
            $query->andWhere([
                'or',
                ['like', 'nombre', $searchValue],
                ['like', 'descripcion', $searchValue],
                ['like', 'id', $searchValue]
            ]);
        }

        if ($categoria_id) {
            $query->andWhere(['categoria_id' => $categoria_id]);
        }

        if ($precio_min) {
            $query->andWhere(['>=', 'precio', $precio_min]);
        }
        if ($precio_max) {
            $query->andWhere(['<=', 'precio', $precio_max]);
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

        $totalRecords = Producto::find()->count();
        $filteredRecords = $query->count();

        $data = $query->offset($start)->limit($length)->asArray()->all();

        return [
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data,
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Crear producto
     */
    public function actionCreate()
    {
        $model = new Producto();
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if ($model->load($data, '') && $model->save()) {
            return $model;
        }

        return ['error' => $model->getErrors()];
    }

    /**
     * Ver un producto específico
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * Actualizar producto
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = json_decode(Yii::$app->request->getRawBody(), true);

        if ($model->load($data, '') && $model->save()) {
            return $model;
        }

        return ['error' => $model->getErrors()];
    }

    /**
     * Eliminar producto
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return ['mensaje' => 'Producto eliminado'];
    }

    /**
     * Buscar modelo o lanzar 404
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Producto no encontrado.');
    }

    public function actionCreateForm()
    {
        return $this->renderPartial('create');
    }

    public function actionUpdateForm($id)
    {
        $model = $this->findModel($id);
        return $this->renderPartial('update', [
            'model' => $model,
        ]);
    }
}
