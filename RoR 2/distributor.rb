class Distributor < ActiveRecord::Base
  attr_accessible :additional_email, 
    :company_name, 
    :company_region, 
    :contact_email, 
    :contact_name, 
    :password,
    :password_confirmation, 
    :remember_token,
    :validate_url
    
  has_secure_password
  
  before_save { |distributor| distributor.contact_email = contact_email.downcase }
  before_save :create_remember_token
  
  after_initialize :set_defaults
  
  validates :contact_name, presence: true, length: { maximum: 100 }
  validates :company_name, presence: true, length: { maximum: 50 }
	VALID_EMAIL_REGEX = /\A[\w+\.-]+@((?!gmail|hotmail|outlook|aol|yahoo).)[\w\.-]+\.\w{2,8}\z/i
  validates :contact_email, uniqueness: { case_sensitive: false }, presence: true, format: { with: VALID_EMAIL_REGEX }
  
  private
  
    def set_defaults
      if self.new_record?
        self.password = "t3mp88"
        self.password_confirmation = "t3mp88"
      end
    end
      
    def create_remember_token
      self.remember_token = SecureRandom.urlsafe_base64
    end
    
    def create_validate_info
      self.validate_url = SecureRandom.urlsafe_base64
      #self.validate_code = SecureRandom.urlsafe_base64
    end  
    
  def self.to_csv(options = {})
    CSV.generate(options) do |csv|
      csv << column_names
      all.each do |distributor|
        csv << distributor.attributes.values_at(*column_names)
      end
    end
  end
  
end
