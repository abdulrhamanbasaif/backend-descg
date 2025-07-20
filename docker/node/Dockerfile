FROM node:22

WORKDIR /app

# ننسخ ملفات التعريف فقط لتثبيت التبعيات أولاً
COPY ./frontend/package*.json ./
RUN npm install

# بعد التثبيت انسخ بقية الكود
COPY ./frontend .

# استمع على كل الواجهات داخل الحاوية
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "5173"]