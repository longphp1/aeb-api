<?php

namespace App\Services\Admin;

use App\Exceptions\AccidentException;
use App\Exceptions\ImportErrorException;
use App\Lib\Code;
use App\Models\System\Dept;
use App\Models\System\Role;
use App\Models\System\UserRole;
use App\Models\SysUser;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{

    protected $model;

    protected $filterRules = [
        'username,nickname,email,mobile' => ['like', 'keyword'],
    ];

    protected $orderBy = [
        'id' => 'desc',
    ];

    public function __construct()
    {
        $this->request = request();
        $this->formData = $this->request->all();
        $this->model = new User();
        $this->query = $this->model->newQuery();
        $this->setFilterRules();
    }

    // 修复语法错误：添加缺失的闭合大括号
    public function show(int $id)
    {
        return parent::show($id);
    }

    public function index()
    {
        $this->getFilter($this->query);
        $this->query->with(['dept', 'createdBy', 'updatedBy']);
        return parent::index();
    }

    public function store($params)
    {
        validator($params, [
            'username' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|integer|in:0,1,2',
            'status' => 'required|integer|in:0,1,2',
            'deptId' => 'required|integer',
            'roleIds' => 'sometimes|nullable|array',
            'mobile' => 'sometimes|nullable|string',
            'email' => 'required|email',
            'is_audited' => 'sometimes|nullable|integer',
            'forbid_login' => 'sometimes|nullable|integer',
            'avatar' => 'sometimes|nullable|string',
            'openId' => 'sometimes|nullable|string',
        ])->validate();
        $code = $this->checkUserName($params);
        if ($code!= Code::SUCCESS) {
            return $code;
        }
        $data = $this->model::init($this->formData,'add');
        DB::transaction(function () use ($data, $params) {
            $user = $this->query->create($data);
            $userRoleList = [];
            foreach ($params['roleIds'] as $roleId) {
                $userRoleList[] = [
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                    'company_id' => auth()->user()->company_id ?? 0
                ];
            }
            if (!empty($userRoleList)) {
                UserRole::insert($userRoleList);
            }
        });
        return Code::SUCCESS;
    }

    public function update(int $id, $params)
    {
        validator($params, [
            'username' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|integer|in:0,1,2',
            'status' => 'required|integer|in:0,1,2',
            'deptId' => 'required|integer',
            'roleIds' => 'sometimes|nullable|array',
            'mobile' => 'sometimes|nullable|string',
            'email' => 'required|email',
            'is_audited' => 'sometimes|nullable|integer',
            'forbid_login' => 'sometimes|nullable|integer',
            'avatar' => 'sometimes|nullable|string',
            'openId' => 'sometimes|nullable|string',
        ])->validate();
        /*$code = $this->checkUserName($params);
        if ($code!= Code::SUCCESS) {
            return $code;
        }*/
        $user = $this->query->findOrFail($id);
        if ($user) {
            DB::transaction(function () use ($user, $id, $params) {
                $updateData = $this->model::init($params,'update');
                $this->query->where('id',$id)->update($updateData);
                UserRole::where('user_id', $id)->delete();
                $userRoleList = [];
                foreach ($params['roleIds'] as $roleId) {
                    $userRoleList[] = [
                        'user_id' => $id,
                        'role_id' => $roleId,
                        'company_id' => auth()->user()->company_id ?? 0
                    ];
                }
                if (!empty($userRoleList)) {
                    UserRole::insert($userRoleList);
                }
            });
            return Code::SUCCESS;
        }
        return Code::USER_NOT_EXIST;
    }

    public function checkUserName($params){
        $user = $this->query->where('username', $params['username'])->first();
        if ($user) {
            return Code::USERNAME_ALREADY_EXISTS;
        }
        return Code::SUCCESS;
    }

    public function destroy($id)
    {
        $ids = _id($id);
        return $this->query->whereIn('id', $ids)->delete();
    }

    public function enable(int $id)
    {
        return $this->setStatus($id, 1);
    }

    public function disable(int $id)
    {
        return $this->setStatus($id, 0);
    }

    private function setStatus(int $id, int $status)
    {
        $user = $this->query->findOrFail($id);
        return $user->update(['status' => $status]);
    }

    public function getFilter(&$query)
    {
        if(isset($this->formData['createTime'])){
            $query->whereBetween('created_at', [
                Carbon::parse($this->formData['createTime'][0])->startOfDay(),
                Carbon::parse($this->formData['createTime'][1])->endOfDay()
            ]);
        }
        if (isset($this->formData['nickname']) && !empty($this->formData['nickname'])) {
            $query->where('nickname', trim($this->formData['nickname']));
        }
        if (isset($this->formData['status'])){
            $query->where('status', $this->formData['status']);
        }
        if (isset($this->formData['deptId'])){
            $query->where('dept_id', $this->formData['deptId']);
        }
        if (isset($this->formData['keywords'])) {
            $query->where(function ($query) {
                $query->where('nickname', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('mobile', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('email', 'like', '%' . $this->formData['keywords'] . '%')
                    ->orWhere('mobile', 'like', '%' . $this->formData['keywords'] . '%');
            });
        }
    }

    public function export($params)
    {
        $this->getFilter($this->query);
        $this->query->with(['dept', 'createdBy', 'updatedBy']);
        $dataList = parent::all();
        $newData = [];
        if ($dataList) {
            foreach ($dataList as $row) {
                $newData[] = [
                    $row->username,
                    $row->nickname,
                    $row->dept->name ?? '',
                    $row->gender == 1 ? '男' : ($row->gender == 2 ? '女' : '未知'),
                    $row->mobile,
                    $row->email,
                    $row->updated_at!=null? \Carbon\Carbon::parse($row->updated_at)->format('Y/m/d H:i'):null
                ];

            }
        }


        $config = [
            'path' => storage_path('app'),
        ];

        $excel = new \Vtiful\Kernel\Excel($config);

        $header = [
            'User Name',
            'Nick Name',
            'Department',
            'Gender',
            'Mobile',
            'Email',
            'Created At',
        ];

        $fileName = 'user-info-export.xlsx';

        // fileName 会自动创建一个工作表，你可以自定义该工作表名称，工作表名称为可选参数
        $filePath = $excel->fileName($fileName, 'sheet1')
            ->header($header)
            ->data($newData)
            ->setColumn('A:L', 50)
            ->output();

        //Set Header
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename=' . $fileName);
        header('Cache-Control: max-age=0');

        if (copy($filePath, 'php://output') === false) {
            // Throw exception
        }

        // Delete temporary file
        @unlink($filePath);
        exit();
    }

    public function import($data)
    {
        validator($data, [
            'deptId' => 'required|integer',
            'file' => 'required|file|mimes:xlsx|max:20480',
        ])->validate();

        $requestFile = $data['file'];
        $excel = new \Vtiful\Kernel\Excel(['path' => $requestFile->getPath()]);
        $sheetDataList = $excel->openFile($requestFile->getFilename())
            ->openSheet()
            ->getSheetData();

        $errors = [];
        $importRows = [];

        foreach ($sheetDataList as $line => $cells) {
            if ($line === 0 || count($cells) === 0) continue;

            if (count($cells) !== 7) { // 修正列数检查（原代码检查6列但实际使用7列）
                throw new AccidentException(__('上传模板格式错误:列数有误') . " 行号:" . ($line + 1));
            }

            $cleanCell = fn($index) => str_replace(PHP_EOL, "", trim($cells[$index] ?? ''));

            $rowData = [
                'username' => $cleanCell(0),
                'nickname' => $cleanCell(1),
                'gender' => $cleanCell(2),
                'mobile' => $cleanCell(3),
                'email' => $cleanCell(4),
                'roleNo' => $cleanCell(5),
                'deptNo' => $cleanCell(6),
            ];

            // 部门验证优化
            $deptInfo = Dept::where('code', $rowData['deptNo'])->first();
            if (!$deptInfo) {
                $errors[] = ['line' => $line + 1, 'error' => "部门代码不存在"];
                continue;
            }

            // 数据验证优化
            $validationErrors = [];
            if (empty($rowData['username'])) $validationErrors[] = "用户名称不能为空";
            if (empty($rowData['email'])) $validationErrors[] = "用户邮箱不能为空";
            if (!filter_var($rowData['email'], FILTER_VALIDATE_EMAIL)) $validationErrors[] = "邮箱格式错误";

            if (!empty($validationErrors)) {
                $errors[] = ['line' => $line + 1, 'error' => implode(",", $validationErrors)];
                continue;
            }

            $importRows[] = [
                ...$rowData,
                'dept_id' => $deptInfo->id,
                'roleNoList' => explode(',', $rowData['roleNo']),
                'company_id' => auth()->user()->company_id ?? 0,
                'created_at' => now(),
                'create_by' => auth()->user()->id ?? 0
            ];
        }

        // 批量验证用户存在性
        $existingEmails = SysUser::whereIn('email', array_column($importRows, 'email'))->pluck('email');
        foreach ($importRows as $index => $row) {
            if ($existingEmails->contains($row['email'])) {
                $errors[] = ['line' => $index + 2, 'error' => "邮箱已存在"];
                unset($importRows[$index]);
            }
        }

        if (!empty($errors)) {
            throw new ImportErrorException($errors);
        }

        return DB::transaction(function () use ($importRows) {
            foreach ($importRows as $row) {
                $user = SysUser::create([
                    'username' => $row['username'],
                    'nickname' => $row['nickname'],
                    'gender' => $row['gender'],
                    'mobile' => $row['mobile'],
                    'email' => $row['email'],
                    'dept_id' => $row['dept_id'],
                    'company_id' => $row['company_id'],
                    'created_at' => $row['created_at'],
                    'create_by' => $row['create_by']
                ]);

                // 优化角色分配
                if (!empty($row['roleNoList'])) {
                    $roleIds = Role::whereIn('code', $row['roleNoList'])->pluck('id');
                    $userRoles = $roleIds->map(fn($id) => [
                        'user_id' => $user->id,
                        'role_id' => $id,
                        'company_id' => $user->company_id
                    ])->all();
                    UserRole::insert($userRoles);
                }
            }
            return true;
        });
    }

    public function resetPassword($id, $params)
    {
        $user = $this->query->findOrFail($id);
        if ($user) {
            $user->password = bcrypt($params['password']);
            return $user->update();
        }
        return false;
    }

    public function changeStatus(int $id, $params)
    {
        $user = $this->query->findOrFail($id);
        if ($user) {
            return $user->update(['status' => $params['status']]);
        }
        return false;
    }

    public function updateProfile($data)
    {
        validator($data, [
            'id' => 'required|integer',
            'username' => 'required|string',
            'nickname' => 'required|string',
            'gender' => 'required|integer|in:0,1,2',
            'mobile' => 'sometimes|nullable|string',
            'email' => 'required|email',
            'avatar' => 'sometimes|string',
        ])->validate();

        $user = $this->query->findOrFail($data['id']);
        if ($user) {
            $updateData = [
                'username' => $data['username'],
                'nickname' => $data['nickname'],
                'gender' => $data['gender'],
                'mobile' => $data['mobile'],
                'email' => $data['email'],
                'avatar' => $data['avatar'] ?? '',
                'updated_at' => Carbon::now()->toDateTimeString(),
                'update_by' => auth()->user()->id ?? 0
            ];
            return $user->update($updateData);
        }
        return false;
    }

    public function updatePassword($data)
    {
        validator($data, [
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string'
        ])->validate();
        $user = $this->query->findOrFail(auth()->user()->id);
        if ($user) {
            if (!password_verify($data['oldPassword'], $user->password)) {
                throw new AccidentException(__('原密码错误'));
            }
            $user->password = bcrypt($data['newPassword']);
            return $user->update();
        }
        return false;
    }

    public function optionsList($data)
    {
        $userList = $this->query->get();
        return $userList->map(function ($user) {
            return [
                'value' => $user->id,
                'label' => $user->username,
            ];
        });
    }

}
