<?php
ob_start();
include("header.php");
?>

<?php
$db = new Policies();

// Handle delete action
if (!empty($_GET['del'])) {
    $id = base64_decode($_GET['del']);
    $db->deletePolicy($id);
    header("Location: PolicyManagement.php");
    exit();
}

// Handle form submission for adding or updating policies
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $policy_type = trim($_POST['policy_type']);
    $content = trim($_POST['content']);
    $error = "";
    $success = "";

    // If no errors, proceed to insert or update in the database
    if (empty($error)) {
        // Fetch existing policy
        $existing_policies = $db->getAllPolicies();
        $existing_policy = $existing_policies->fetch_assoc();

        // Prepare the policy data array
        $policy_data = [
            'privacy_policy' => $existing_policy['privacy_policy'] ?? '',
            'terms_and_conditions' => $existing_policy['terms_and_conditions'] ?? '',
            'shipping_and_return' => $existing_policy['shipping_and_return'] ?? '',
            'refund_policy' => $existing_policy['refund_policy'] ?? '',
        ];

        // Update the specific policy type
        $policy_data[$policy_type] = $content;

        // If no existing policy, add a new one
        if (!$existing_policy) {
            $result = $db->addPolicy(
                $policy_data['privacy_policy'], 
                $policy_data['terms_and_conditions'], 
                $policy_data['shipping_and_return'], 
                $policy_data['refund_policy'], 
            );
        } else {
            // Update existing policy
            $result = $db->updatePolicy(
                $existing_policy['id'], 
                $policy_data['privacy_policy'], 
                $policy_data['terms_and_conditions'], 
                $policy_data['shipping_and_return'], 
                $policy_data['refund_policy'], 
            );
        }

        if ($result) {
            $success = "Policy updated successfully!";
        } else {
            $error = "Failed to update policy. Please try again.";
        }
    }
}

// Fetch existing policies for display
$policies = $db->getAllPolicies();
$existing_policy = $policies->fetch_assoc() ?? [];
?>

<style>
.ck-editor__editable_inline {
    min-height: 400px;
    resize: vertical;
    overflow: auto;
    border: 1px solid #e0e0e0;
}
.message {
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 4px;
    text-align: center;
}
.success { background-color: #d4edda; color: #155724; }
.error { background-color: #f8d7da; color: #721c24; }

/* Enhanced Table Design */
.policy-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 20px;
    box-shadow: 0 2px 3px rgba(0,0,0,0.1);
}
.policy-table th, .policy-table td {
    border: 1px solid #e0e0e0;
    padding: 12px;
    text-align: left;
    transition: background-color 0.3s ease;
}
.policy-table th {
    background-color: #f8f9fa;
    color: #333;
    font-weight: 600;
    text-transform: uppercase;
}
.policy-table tr:nth-child(even) {
    background-color: #f9f9f9;
}
.policy-table tr:hover {
    background-color: #f1f3f5;
}
.policy-table .policy-type {
    width: 15%;
    font-weight: 500;
    color: #6f42c1;
}
.policy-table .policy-preview {
    width: 85%;
    color: #666;
}
.policy-preview-text {
    max-height: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<div id="page-wrapper">
    <div class="graphs">
        <h3 class="blank1">Manage Policies</h3>

        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="xs" style="margin-bottom: 20px;">
            <div class="bs-example4" data-example-id="form-example">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #333;">
                    Update Policy
                </h4>
                <form id="add-policy-form" action="" method="post" style="background: #f9f9f9; padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; width: 100%; box-sizing: border-box;">
                    <div style="width: 100%; margin-bottom: 15px;">
                        <label for="policy_type" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Select Policy</label>
                        <select id="policy_type" name="policy_type" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; background: #fff;">
                            <option value="privacy_policy">Privacy Policy</option>
                            <option value="terms_and_conditions">Terms and Conditions</option>
                            <option value="shipping_and_return">Shipping and Return</option>
                            <option value="refund_policy">Refund Policy</option>
                        </select>
                    </div>

                    <div style="width: 100%; margin-bottom: 15px;">
                        <label for="content" style="display: block; font-size: 14px; color: #555; margin-bottom: 5px;">Policy Content</label>
                        <textarea id="content" name="content" placeholder="Enter policy content"></textarea>
                    </div>

                    <div style="width: 100%; margin-top: 10px;">
                        <button type="submit" style="width: 100%; padding: 8px; background: #6f42c1; color: #fff; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;">
                            Update Policy
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="xs tabls">
            <div class="bs-example4" data-example-id="contextual-table">
                <table class="table policy-table" id="policy-table">
                    <thead>
                        <tr>
                            <th class="policy-type">Policy</th>
                            <th class="policy-preview">Content Preview</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $policy_types = [
                            'privacy_policy' => 'Privacy Policy',
                            'terms_and_conditions' => 'Terms & Conditions',
                            'shipping_and_return' => 'Shipping & Return',
                            'refund_policy' => 'Refund Policy',
                        ];

                        foreach ($policy_types as $key => $label): ?>
                            <tr>
                                <td class="policy-type"><?php echo htmlspecialchars($label); ?></td>
                                <td class="policy-preview">
                                    <div class="policy-preview-text">
                                        <?php 
                                        $content = $existing_policy[$key] ?? '';
                                        // Remove HTML tags and truncate
                                        $stripped_content = strip_tags($content);
                                        echo htmlspecialchars(substr($stripped_content, 0, 500) . (strlen($stripped_content) > 500 ? '...' : '')); 
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include("copyright.php"); ?>
</div>

<?php include("footer.php"); ?>

<script>
    let policies = <?php echo json_encode($existing_policy ?? []); ?>;
    let editor;

    // Initialize CKEditor for the textarea
    ClassicEditor
        .create(document.querySelector('textarea'), {
            height: '400px',
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
        })
        .then(newEditor => {
            editor = newEditor;
            // Set initial content based on first option
            updateEditorContent('about_us');
        })
        .catch(error => {
            console.error('There was a problem initializing the editor', error);
        });

    // Update textarea content when policy type changes
    document.getElementById('policy_type').addEventListener('change', function() {
        var policyType = this.value;
        updateEditorContent(policyType);
    });

    // Function to update editor content
    function updateEditorContent(policyType) {
        if (editor) {
            editor.setData(policies[policyType] || '');
        }
    }
</script>